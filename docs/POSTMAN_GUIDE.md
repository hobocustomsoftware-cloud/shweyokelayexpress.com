# Postman နဲ့ API စမ်းနည်း

---

## ၁။ Base URL သတ်မှတ်ပါ

- **Local:** `http://127.0.0.1:8000/api/v1`
- **Production:** `https://cargo.shweyokelayexpress.com/api/v1`

Postman မှာ **Environment** သုံးချင်ရင် variable ထည့်ပါ။ ဥပမာ: `base_url` = `http://127.0.0.1:8000/api/v1`

---

## ၂။ Login စမ်းပါ (Token ယူရန်)

1. **New Request** ဖွင့်ပါ။
2. **Method:** `POST` ရွေးပါ။
3. **URL:** `http://127.0.0.1:8000/api/v1/login` (local) သို့မဟုတ် production URL ထည့်ပါ။
4. **Headers** tab မှာ:
   - Key: `Accept` → Value: `application/json`
   - Key: `Content-Type` → Value: `application/json`
5. **Body** tab မှာ:
   - **raw** ရွေးပါ။
   - **JSON** ရွေးပါ။
   - အောက်က ထည့်ပါ (username / password ကို ကိုယ့် DB ထဲက user နဲ့ ပြောင်းပါ):

```json
{
    "name": "admin",
    "password": "your_password"
}
```

6. **Send** နှိပ်ပါ။
7. **Response** မှာ အောင်မြင်ရင် အောက်လို ပါမယ်:

```json
{
    "success": true,
    "result": {
        "token": "1|xxxxxxxxxxxx...",
        "user": { "id": 1, "name": "admin", "email": "...", "role": "Admin" }
    },
    "message": "Login successful"
}
```

8. **`result.token`** ကို ကူးပြီး သိမ်းထားပါ။ နောက် request တွေမှာ သုံးမယ်။

---

## ၃။ Token နဲ့ Protected API စမ်းပါ (ဥပမာ ကုန်စာရင်း)

1. **New Request** (သို့) လက်ရှိ request ကို ပြင်ပါ။
2. **Method:** `GET`
3. **URL:** `http://127.0.0.1:8000/api/v1/cargos`
4. **Headers** tab မှာ:
   - Key: `Accept` → Value: `application/json`
   - Key: `Authorization` → Value: `Bearer 1|xxxxxxxxxxxx...`  
     (Login ကနေ ယူထားတဲ့ **token** ကို `Bearer ` နောက်မှာ ထည့်ပါ။ နေရာလွတ် တစ်ခု ထားရပါမယ်။)
5. **Send** နှိပ်ပါ။
6. အောင်မြင်ရင် ကုန်စာရင်း JSON ပြန်မယ်။

---

## ၄။ အခြား API များ စမ်းနည်း (တူညီပါတယ်)

| စမ်းချင်တာ | Method | URL | Body (လိုရင်) |
|--------------|--------|-----|-----------------|
| API စာရင်း ကြည့်ရန် | GET | .../api/v1/ | မလို |
| Register | POST | .../api/v1/register | `{"name":"...","email":"...","password":"..."}` |
| Logout | POST | .../api/v1/logout | မလို (Header မှာ token ထည့်ပါ) |
| Cities | GET | .../api/v1/cities | မလို |
| Gates (မြို့အလိုက်) | GET | .../api/v1/gates/1 | မလို (1 က city_id) |
| Cargo Types | GET | .../api/v1/cargo_types | မလို |
| Merchants | GET | .../api/v1/merchants | မလို |
| Cars | GET | .../api/v1/cars | မလို |

**Token လိုသော request အားလုံးမှာ** Header မှာ ဒီလို ထည့်ပါ:
- `Authorization` : `Bearer <login ကနေ ယူထားသော token>`

---

## ၅။ Postman Collection သိမ်းချင်ရင်

1. Request တွေ ဖန်တီးပြီးရင် **Save** လုပ်ပါ။
2. **Collections** ထဲမှာ **New Collection** ဖန်တီးပြီး request တွေကို ထည့်သိမ်းနိုင်ပါတယ်။
3. **Environment** မှာ `base_url` ထည့်ပြီး URL မှာ `{{base_url}}/login` စသဖြင့် သုံးနိုင်ပါတယ်။

---

## ၆။ မှတ်ချက်များ

- **401 Unauthenticated** ပြန်ရင် → Token မထည့်ရသေး (သို့) မှားနေလို့။ Login ပြန်ခေါ်ပြီး token အသစ်ယူပါ။
- **422** ပြန်ရင် → Body ထဲက field (name, email, password စသည်) မမှန်လို့။ Error message ထဲမှာ ဘာ မှားကြောင်း ပါပါလိမ့်မယ်။
- **500** ပြန်ရင်:
  1. **storage/logs/laravel.log** ဖိုင်ထဲမှာ `API Exception:` ရှာပြီး အမှားအပြည့်အစုံ ကြည့်ပါ။
  2. **.env** မှာ `APP_DEBUG=true` ထားပြီး ထပ်ခေါ်ပါ။ Response ထဲမှာ အမှားစာသား ပါလာနိုင်ပါတယ် (local မှာပဲ သုံးပါ)။
  3. DB ချိတ်ပြီးပါစေ။ Migration ပြေးပါ: `php artisan migrate`။ Role လိုရင်: `php artisan db:seed --class=RoleSeeder`။
