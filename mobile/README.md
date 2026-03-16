# Shwe Yoke Lay Express – Mobile (Expo)

React Native Expo app for the Cargo API. Login and view tabs: Home, Cargos, Profile.

## Setup

1. Install dependencies (already done): `npm install`
2. Start Laravel API: from project root run **`php artisan serve --host=0.0.0.0`** so the server is reachable from phone/emulator.
3. Update API URL if needed: edit `src/api/config.ts`: set `API_HOST` to your PC IP (e.g. `'192.168.1.5'`) for iPhone/device (same WiFi), or `'10.0.2.2'` for Android emulator. For Android emulator use `http://10.0.2.2:8000/api/v1`. For a physical device use your computer’s LAN IP, e.g. `http://192.168.1.x:8000/api/v1`

## Run

- **Web:** `npm run web`
- **Android:** `npm run android` (or Expo Go)
- **iOS:** `npm run ios` (or Expo Go)

## Login

- API login uses **name** and **password** (POST `/api/v1/login`).
- After login, the app stores the token and shows the main tabs; Cargos tab loads the list from the API.
