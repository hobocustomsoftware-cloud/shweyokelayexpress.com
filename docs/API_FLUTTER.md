# Cargo API – Flutter အတွက် အသုံးပြုနည်း

**Base URL:** `https://cargo.shweyokelayexpress.com/api/v1`

**မှတ်ချက်:** Server မှာ migration ပြေးထားရပါမယ်။ `php artisan migrate` (created_by_user_id ကော်လံ ပါဝင်သည့် migration ပါသည်။)

## Response Format

- **အောင်မြင်ခြင်း:** `{ "success": true, "result": {...}, "message": "..." }`
- **မအောင်မြင်ခြင်း:** `{ "success": false, "message": "..." }`

---

## ၁။ Auth (လော့ဂ်အ / စာရင်းသွင်း)

### ၁.၁ Login
- **Method:** `POST`
- **URL:** `/api/v1/login`
- **Body (JSON):**
```json
{
  "name": "username",
  "password": "password"
}
```
- **Response result:** `{ "token": "1|xxx...", "user": { "id", "name", "email", "role" } }`
- **Flutter မှာ:** Login ပြီးရင် `token` ကို သိမ်းပြီး နောက် API ခေါ်တိုင်း Header ထည့်ပါ။  
  `Authorization: Bearer <token>`

### ၁.၂ Register
- **Method:** `POST`
- **URL:** `/api/v1/register`
- **Body (JSON):**
```json
{
  "name": "username",
  "email": "user@example.com",
  "password": "password123"
}
```
- **မှတ်ချက်:** စာရင်းသွင်းသူကို default role `User` ပေးထားပါတယ်။ Admin မဟုတ်ပါ။

### ၁.၃ Logout (Auth လိုအပ်သည်)
- **Method:** `POST`
- **URL:** `/api/v1/logout`
- **Headers:** `Authorization: Bearer <token>`

---

## ၂။ Cargos (Auth လိုအပ်သည်)

### ၂.၁ ကုန်စာရင်း ယူမယ်
- **Method:** `GET`
- **URL:** `/api/v1/cargos?page=1`
- **Headers:** `Authorization: Bearer <token>`
- **Response result:** Paginated list (data, meta: total, currentPage, perPage, links)

### ၂.၂ ကုန် တစ်ခု ကြည့်မယ်
- **Method:** `GET`
- **URL:** `/api/v1/cargos/{id}`

### ၂.၃ ကုန် အသစ် ထည့်မယ်
- **Method:** `POST`
- **URL:** `/api/v1/cargos`
- **Content-Type:** `multipart/form-data` (image ပါရင်) သို့မဟုတ် `application/json`
- **Body (JSON ဖြစ်ရင်):**
  - s_name, s_phone, s_nrc, s_address (ပို့သူ)
  - r_name, r_phone, r_nrc, r_address (လက်ခံသူ)
  - from_city_id, to_city_id, from_gate_id, to_gate_id
  - items: `[{ "cargo_type_id": 1, "quantity": 1, "detail": null, "notice": null }]`
  - service_charge, short_deli_fee, border_fee, transit_fee, total_fee, to_pick_date
  - image (optional, file)
  - car_id (optional)

### ၂.၄ ကုန် ပြင်မယ်
- **Method:** `PUT` / `PATCH`
- **URL:** `/api/v1/cargos/{id}`

### ၂.၅ ကုန် ဖျက်မယ်
- **Method:** `DELETE`
- **URL:** `/api/v1/cargos/{id}`

---

## ၃။ Cities
- **Method:** `GET`
- **URL:** `/api/v1/cities` (paginated)

## ၄။ Gates (မြို့အလိုက် ဂိတ်)
- **Method:** `GET`
- **URL:** `/api/v1/gates/{city_id}`

## ၅။ Cargo Types
- **Method:** `GET`
- **URL:** `/api/v1/cargo_types`

## ၆။ Merchants
- **Method:** `GET`
- **URL:** `/api/v1/merchants`

## ၇။ Cars
- **Method:** `GET`
- **URL:** `/api/v1/cars`

## ၈။ Transit Cargos
- **List:** `GET /api/v1/transit_cargos?page=1`
- **Create:** `POST /api/v1/transit_cargos`
- **Show:** `GET /api/v1/transit_cargos/{id}`

## ၉။ Transit Passengers
- **Resource:** `GET/POST/GET/PUT/DELETE` `/api/v1/transit_passengers` (apiResource)

## ၁၀။ Load Cargos
- **List:** `GET /api/v1/load_cargos`
- **Show:** `GET /api/v1/load_cargos/{id}`
- **Assign car:** `POST /api/v1/load_cargos/assign`  
  Body: `car_id`, `cargo_id`, `user_id`, `arrived_at`
- **Search:** `POST /api/v1/load_cargos/search`

---

## Flutter မှာ Token သုံးနည်း

1. Login/Register ပြီးရင် `result['token']` ကို secure storage (ဥပမာ `flutter_secure_storage`) မှာ သိမ်းပါ။
2. HTTP client (Dio / http) မှာ interceptor ထည့်ပြီး request တိုင်းမှာ  
   `headers['Authorization'] = 'Bearer $token';` ထည့်ပါ။
3. 401 ပြန်ရင် token သက်တမ်းကုန် (သို့) မမှား – ပြန် login လုပ်ခိုင်းပါ။

---

## Base URL ပြောင်းချင်ရင်

Flutter project မှာ `baseUrl` ကို constant တစ်ခု ထားပြီး အားလုံး ဒီ constant သုံးပါ။  
ဥပမာ: `const baseUrl = 'https://cargo.shweyokelayexpress.com/api/v1';`
