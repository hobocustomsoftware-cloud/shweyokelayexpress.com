/**
 * API host for Laravel backend.
 * - iPhone/Android device: Use your PC's IP (e.g. 192.168.1.5). PC and phone must be on same WiFi.
 *   On PC run: php artisan serve --host=0.0.0.0
 * - Android emulator: use 10.0.2.2
 * - Web / local: 127.0.0.1
 */
export const API_HOST = '127.0.0.1'; // Change to your PC IP when testing on real device (e.g. '192.168.1.5')
export const API_PORT = '8000';
export const API_BASE_URL = `http://${API_HOST}:${API_PORT}/api/v1`;
