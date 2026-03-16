import { API_BASE_URL } from './config';

export type ApiResponse<T = unknown> = {
  success: boolean;
  result?: T;
  message: string;
};

export async function apiRequest<T>(
  path: string,
  options: RequestInit & { token?: string } = {}
): Promise<ApiResponse<T>> {
  const { token, ...init } = options;
  const url = path.startsWith('http') ? path : `${API_BASE_URL}${path.startsWith('/') ? '' : '/'}${path}`;
  const headers: HeadersInit = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    ...(init.headers as Record<string, string>),
  };
  if (token) {
    (headers as Record<string, string>)['Authorization'] = `Bearer ${token}`;
  }
  let res: Response;
  try {
    res = await fetch(url, { ...init, headers });
  } catch (err) {
    const msg = err instanceof Error ? err.message : String(err);
    throw new Error('Network error: ' + msg);
  }
  const text = await res.text();
  let data: ApiResponse<T> | Record<string, unknown> = {};
  try {
    data = text ? JSON.parse(text) : {};
  } catch {
    if (!res.ok) {
      throw new Error(`Request failed ${res.status}: ${text.slice(0, 100)}`);
    }
    throw new Error('Invalid JSON response');
  }
  if (!res.ok) {
    const message = (data as Record<string, unknown>)?.message;
    throw new Error(typeof message === 'string' ? message : `Request failed ${res.status}`);
  }
  return data as ApiResponse<T>;
}

export type LoginBody = { name: string; password: string };
export type LoginResult = { token: string; user: { id: number; name: string; email?: string; role?: string } };

export function login(body: LoginBody) {
  return apiRequest<LoginResult>('/login', {
    method: 'POST',
    body: JSON.stringify(body),
    credentials: 'omit',
  });
}

export function logout(token: string) {
  return apiRequest('/logout', { method: 'POST', token });
}

export function getCargos(token: string) {
  return apiRequest<unknown>('/cargos', { method: 'GET', token });
}

export function getCities(token: string) {
  return apiRequest<unknown>('/cities', { method: 'GET', token });
}
