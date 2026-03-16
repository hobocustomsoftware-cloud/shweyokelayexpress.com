import React, { createContext, useCallback, useContext, useEffect, useState } from 'react';
import { login as apiLogin, logout as apiLogout, LoginResult } from '../api/client';

type User = LoginResult['user'];

type AuthState = {
  token: string | null;
  user: User | null;
  isLoading: boolean;
  isLoggedIn: boolean;
};

type AuthContextValue = AuthState & {
  login: (name: string, password: string) => Promise<void>;
  logout: () => Promise<void>;
  setStored: (token: string | null, user: User | null) => void;
};

const AuthContext = createContext<AuthContextValue | null>(null);

const TOKEN_KEY = '@cargo_token';
const USER_KEY = '@cargo_user';

async function getStored(): Promise<{ token: string | null; user: User | null }> {
  try {
    const { default: AsyncStorage } = await import('@react-native-async-storage/async-storage');
    const [token, userJson] = await Promise.all([
      AsyncStorage.getItem(TOKEN_KEY),
      AsyncStorage.getItem(USER_KEY),
    ]);
    const user = userJson ? (JSON.parse(userJson) as User) : null;
    return { token, user };
  } catch {
    return { token: null, user: null };
  }
}

async function setStored(token: string | null, user: User | null) {
  try {
    const { default: AsyncStorage } = await import('@react-native-async-storage/async-storage');
    if (token && user) {
      await AsyncStorage.setItem(TOKEN_KEY, token);
      await AsyncStorage.setItem(USER_KEY, JSON.stringify(user));
    } else {
      await AsyncStorage.multiRemove([TOKEN_KEY, USER_KEY]);
    }
  } catch {}
}

export function AuthProvider({ children }: { children: React.ReactNode }) {
  const [state, setState] = useState<AuthState>({
    token: null,
    user: null,
    isLoading: true,
    isLoggedIn: false,
  });

  const setStoredAndState = useCallback((token: string | null, user: User | null) => {
    setStored(token, user);
    setState({
      token,
      user,
      isLoading: false,
      isLoggedIn: !!token,
    });
  }, []);

  useEffect(() => {
    let cancelled = false;
    getStored().then(({ token, user }) => {
      if (!cancelled) {
        setState({
          token,
          user,
          isLoading: false,
          isLoggedIn: !!token,
        });
      }
    });
    return () => { cancelled = true; };
  }, []);

  const login = useCallback(
    async (name: string, password: string) => {
      const res = await apiLogin({ name, password });
      if (!res.success) throw new Error(res.message || 'Login failed');
      const raw = res.result as { token?: string; user?: Record<string, unknown> } | null | undefined;
      const token = raw?.token ?? null;
      const u = raw?.user;
      if (!token || !u || typeof u !== 'object') throw new Error(res.message || 'Invalid login response');
      const user: User = {
        id: Number((u as Record<string, unknown>).id) || 0,
        name: String((u as Record<string, unknown>).name ?? ''),
        email: (u as Record<string, unknown>).email != null ? String((u as Record<string, unknown>).email) : undefined,
        role: (u as Record<string, unknown>).role != null ? String((u as Record<string, unknown>).role) : undefined,
      };
      setStoredAndState(token, user);
    },
    [setStoredAndState]
  );

  const logout = useCallback(async () => {
    if (state.token) {
      try {
        await apiLogout(state.token);
      } catch {}
    }
    setStoredAndState(null, null);
  }, [state.token, setStoredAndState]);

  const value: AuthContextValue = {
    ...state,
    login,
    logout,
    setStored: setStoredAndState,
  };

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
}

export function useAuth() {
  const ctx = useContext(AuthContext);
  if (!ctx) throw new Error('useAuth must be used within AuthProvider');
  return ctx;
}
