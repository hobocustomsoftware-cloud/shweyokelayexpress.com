import React, { useState } from 'react';
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  StyleSheet,
  ActivityIndicator,
  KeyboardAvoidingView,
  Platform,
  Alert,
} from 'react-native';
import { useAuth } from '../context/AuthContext';
import { API_BASE_URL } from '../api/config';

export default function LoginScreen() {
  const { login } = useAuth();
  const [name, setName] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);

  const handleLogin = async () => {
    if (!name.trim() || !password) {
      Alert.alert('Error', 'Name and password are required.');
      return;
    }
    setLoading(true);
    try {
      await login(name.trim(), password);
    } catch (e) {
      const msg = e instanceof Error ? e.message : 'Please try again.';
      const isNetwork =
        /network|fetch|failed|ECONNREFUSED|ETIMEDOUT|Network error/i.test(msg) ||
        (e instanceof TypeError && msg.includes('fetch'));
      const fullMsg = isNetwork
        ? `Network error. 1) API: ${API_BASE_URL} 2) Use PC IP in config.ts if on phone. 3) Same WiFi. 4) Run: php artisan serve --host=0.0.0.0`
        : msg;
      Alert.alert('Login failed', fullMsg);
    } finally {
      setLoading(false);
    }
  };

  return (
    <KeyboardAvoidingView
      style={styles.container}
      behavior={Platform.OS === 'ios' ? 'padding' : undefined}
    >
      <View style={styles.card}>
        <Text style={styles.title}>Shwe Yoke Lay Express</Text>
        <Text style={styles.subtitle}>Sign in</Text>
        <Text style={styles.apiUrl} numberOfLines={1}>API: {API_BASE_URL}</Text>
        <TextInput
          style={styles.input}
          placeholder="Name"
          value={name}
          onChangeText={setName}
          autoCapitalize="none"
          autoCorrect={false}
          editable={!loading}
        />
        <TextInput
          style={styles.input}
          placeholder="Password"
          value={password}
          onChangeText={setPassword}
          secureTextEntry
          editable={!loading}
        />
        <TouchableOpacity
          style={[styles.button, loading && styles.buttonDisabled]}
          onPress={handleLogin}
          disabled={loading}
        >
          {loading ? (
            <ActivityIndicator color="#fff" />
          ) : (
            <Text style={styles.buttonText}>Login</Text>
          )}
        </TouchableOpacity>
      </View>
    </KeyboardAvoidingView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#1a1a2e',
    justifyContent: 'center',
    padding: 24,
  },
  card: {
    backgroundColor: '#16213e',
    borderRadius: 12,
    padding: 24,
  },
  title: {
    fontSize: 22,
    fontWeight: '700',
    color: '#eee',
    textAlign: 'center',
    marginBottom: 4,
  },
  subtitle: {
    fontSize: 14,
    color: '#8892b0',
    textAlign: 'center',
    marginBottom: 8,
  },
  apiUrl: {
    fontSize: 11,
    color: '#5a6a8a',
    textAlign: 'center',
    marginBottom: 16,
  },
  input: {
    backgroundColor: '#0f3460',
    borderRadius: 8,
    padding: 14,
    color: '#eee',
    fontSize: 16,
    marginBottom: 12,
  },
  button: {
    backgroundColor: '#e94560',
    borderRadius: 8,
    padding: 16,
    alignItems: 'center',
    marginTop: 8,
  },
  buttonDisabled: {
    opacity: 0.7,
  },
  buttonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: '600',
  },
});
