import React, { useEffect, useState } from 'react';
import { View, Text, StyleSheet, FlatList, ActivityIndicator, RefreshControl } from 'react-native';
import { useAuth } from '../context/AuthContext';
import { getCargos, ApiResponse } from '../api/client';

export default function CargosScreen() {
  const { token } = useAuth();
  const [data, setData] = useState<ApiResponse | null>(null);
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);

  const load = async (isRefresh = false) => {
    if (!token) return;
    if (isRefresh) setRefreshing(true);
    else setLoading(true);
    try {
      const res = await getCargos(token);
      setData(res);
    } catch (e) {
      setData({ success: false, message: e instanceof Error ? e.message : 'Failed to load' });
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  useEffect(() => {
    load();
  }, [token]);

  if (loading && !data) {
    return (
      <View style={styles.centered}>
        <ActivityIndicator size="large" color="#e94560" />
      </View>
    );
  }

  const list = Array.isArray(data?.result) ? data.result : (data?.result as { data?: unknown[] })?.data;
  const items = list ?? [];

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Cargos</Text>
      {!data?.success && (
        <Text style={styles.error}>{data?.message ?? 'Error loading cargos'}</Text>
      )}
      <FlatList
        data={items}
        keyExtractor={(_, i) => String(i)}
        refreshControl={
          <RefreshControl refreshing={refreshing} onRefresh={() => load(true)} colors={['#e94560']} />
        }
        renderItem={({ item }: { item: Record<string, unknown> }) => (
          <View style={styles.card}>
            <Text style={styles.cardText}>#{String(item.id ?? '—')} {String(item.reference_no ?? item.reference_number ?? '')}</Text>
          </View>
        )}
        ListEmptyComponent={
          data?.success && items.length === 0
            ? () => <Text style={styles.empty}>No cargos yet.</Text>
            : null
        }
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#1a1a2e',
    padding: 24,
    paddingTop: 48,
  },
  centered: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#1a1a2e',
  },
  title: {
    fontSize: 24,
    fontWeight: '700',
    color: '#eee',
    marginBottom: 16,
  },
  error: {
    color: '#e94560',
    marginBottom: 12,
  },
  empty: {
    color: '#8892b0',
    textAlign: 'center',
    marginTop: 24,
  },
  card: {
    backgroundColor: '#16213e',
    borderRadius: 8,
    padding: 16,
    marginBottom: 8,
  },
  cardText: {
    color: '#eee',
    fontSize: 14,
  },
});
