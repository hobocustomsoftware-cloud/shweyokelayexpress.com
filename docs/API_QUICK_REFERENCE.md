# API စာရင်း (အတိုချုပ်)

**Base URL (local):** `http://127.0.0.1:8000/api/v1`  
**Base URL (production):** `https://cargo.shweyokelayexpress.com/api/v1`

---

## မှတ်ချက်

- **GET /api/v1/** → API နာမည်၊ version နဲ့ endpoint စာရင်း ပြန်သည် (200)။
- **Token လိုသော route များ:** Header မှာ `Authorization: Bearer <token>` ထည့်ပါ။
- Login မှ token ယူပြီး သုံးပါ။

---

## Auth (token မလို)

| Method | URL | မှတ်ချက် |
|--------|-----|------------|
| POST | /api/v1/login | Body: `{"name":"...","password":"..."}` → token + user |
| POST | /api/v1/register | Body: `{"name":"...","email":"...","password":"..."}` |

## Auth (token လို)

| Method | URL |
|--------|-----|
| POST | /api/v1/logout |

## Cargos

| Method | URL |
|--------|-----|
| GET | /api/v1/cargos?page=1 |
| POST | /api/v1/cargos |
| GET | /api/v1/cargos/{id} |
| PUT/PATCH | /api/v1/cargos/{id} |
| DELETE | /api/v1/cargos/{id} |

## Cities, Gates, Cargo Types, Merchants, Cars

| Method | URL |
|--------|-----|
| GET | /api/v1/cities |
| GET | /api/v1/gates/{city_id} |
| GET | /api/v1/cargo_types |
| GET | /api/v1/merchants |
| GET | /api/v1/cars |

## Transit Cargos

| Method | URL |
|--------|-----|
| GET | /api/v1/transit_cargos |
| POST | /api/v1/transit_cargos |
| GET | /api/v1/transit_cargos/{id} |

## Transit Passengers

| Method | URL |
|--------|-----|
| GET | /api/v1/transit_passengers |
| POST | /api/v1/transit_passengers |
| GET | /api/v1/transit_passengers/{id} |
| PUT/PATCH | /api/v1/transit_passengers/{id} |
| DELETE | /api/v1/transit_passengers/{id} |

## Load Cargos

| Method | URL |
|--------|-----|
| GET | /api/v1/load_cargos |
| GET | /api/v1/load_cargos/{id} |
| POST | /api/v1/load_cargos/assign |
| POST | /api/v1/load_cargos/search |

---

## Local မှာ Login 500 ပြန်ရင်

MySQL (သို့) DB server မလည်နေရင် connection error ကြောင့် 500 ပြန်နိုင်သည်။  
DB ကို စတင်ပြီး `.env` မှာ `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` မှန်အောင် ထားပါ။

---

## Mobile app (Expo) ချိတ်ဆက်ခြင်း

- **Backend (ဒီ project):** `php artisan serve --host=0.0.0.0` ဖြင့် run ပါ။
- **shweyokelay_cargo_app:** သီးသန့် folder ရှိ Expo app။ `src/api/config.js` မှာ `API_HOST` ကို PC IP (ဖုန်းစမ်းမယ်ဆိုရင်) သို့မဟုတ် `127.0.0.1` (web/emulator) ထားပါ။
- **Login response:** `{ "success": true, "result": { "token": "...", "user": { ... } }, "message": "..." }` — mobile app က `result.token` ယူသုံးသည်။
- **Cargos list:** `GET /api/v1/cargos` ပြန်သည်မှာ `{ "success": true, "result": { "data": [ ... ] }, "message": "..." }` — app က `result.data` ကို list အဖြစ် သုံးသည်။
