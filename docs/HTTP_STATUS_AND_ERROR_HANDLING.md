# HTTP Status နှင့် Error Handling စစ်ဆေးချက်

Browser နှင့် cURL ဖြင့် 301, 302, 400, 401, 403, 404, 422, 500, 503 စစ်ဆေးပြီး ပြင်ဆင်ထားချက်များ။

---

## ၁။ စစ်ဆေးခဲ့သော Status များ

| Status | ဖြစ်သည့်အခြေအနေ | စစ်ဆေးနည်း |
|--------|------------------------|----------------|
| **301** | Permanent redirect (ဥပမာ http→https) | Server/load balancer မှ ပြုလုပ်နိုင်သည်။ လက်ရှိ production တွင် **302** ပြန်နေသည်။ |
| **302** | Login မဝင်ထားလျှင် `/` သို့မဟုတ် `/admin/*` သို့ ခေါ်ရင် login သို့ redirect | ✅ `GET /` → 302 to `/login`။ `GET /admin/cargos` (no auth) → 302 to `/login`။ `/clear-all-cache`, `/clear` ကို auth လိုအောင် ပြင်ထားပြီး → unauthenticated ခေါ်ရင် 302။ |
| **400** | Bad Request (အများအားဖြင့် validation မှားခြင်း) | Laravel မှ validation fail က **422** Unprocessable Entity ပြန်သည်။ 400 ကို custom သုံးချင်ရင် controller မှ ပြန်နိုင်သည်။ |
| **401** | Unauthenticated (token မပါ / မမှား) | ✅ `GET /api/v1/cargos` (no Bearer) → 401။ `POST /api/v1/login` wrong creds → 401။ |
| **403** | Forbidden (ဝင်ထားသော်လည်း ဒီ resource ကို မလုပ်ခွင့်မရှိ) | ✅ Cargo show/update/destroy မှာ ကိုယ့် cargo မဟုတ်ရင် 403 ပြန်အောင် ပြင်ထားပြီး။ |
| **404** | Not Found (route သို့မဟုတ် resource မရှိ) | ✅ `GET /no-such-route` → 404။ API မှာ cargo/transit_cargo/load_cargo not found → 404 ပြန်အောင် sendError(..., 404) သုံးထားပြီး။ |
| **422** | Validation Error | ✅ `POST /api/v1/login` body မပါ / မမှား → 422။ `POST /api/v1/register` invalid email/password → 422။ |
| **500** | Server Error | ✅ Register exception → 500 ပြန်အောင် try/catch ထည့်ထားပြီး။ Create cargo/transit cargo/upload image fail → sendError(..., 500)။ Global exception handler မှ unexpected exception → 500 JSON ပြန်သည်။ |
| **503** | Service Unavailable | Laravel maintenance mode: `php artisan down` လုပ်ထားရင် 503 ပြန်သည်။ |

---

## ၂။ ပြင်ဆင်ပြီး အချက်များ (Codebase)

### ၂.၁ API Error Response များ (success: false + မှန်ကန်သော status)

- **CargoApiController:** Cargo not found → `sendError('Cargo not found', 404)`။ Forbidden → `sendError('Forbidden', 403)`။ Failed to create/upload → `sendError(..., 500)`။ (ယခင်က sendResponse(null, message, 404) ဖြစ်နေသဖြင့် body မှာ success: true ပါနေခဲ့သည်။)
- **TransitCargoApiController:** Transit cargo not found → 404။ Failed to upload/create → 500။
- **LoadCargoApiController:** Car cargo / Cargo not found → 404။
- **TransitPassengerApiController:** Not found → 404။ Create failed / exception → 500။
- **CityApiController / GateApiController:** List ဗလာ ဖြစ်လျှင် 200 + empty collection ပြန်အောင် ပြင်ထားသည် (404 မပြန်တော့ပါ)။

### ၂.၂ Global Exception Handler (bootstrap/app.php)

- `request()->is('api/*')` ဖြစ်သည့် request များအတွက် exception ဖြစ်ပါက JSON ပြန်အောင် render callback ထည့်ထားသည်။
- `NotFoundHttpException` → 404။
- `HttpException` → exception ရဲ့ status code အတိုင်း။
- `ValidationException` → Laravel က 422 ပြန်အောင် လုပ်ထားသောကြောင့် handler မှ null return (default behavior သုံး)။
- အခြား exception များ → 500 + `{ "success": false, "message": "Server error" }`။

### ၂.၃ Web (Browser) Routes

- `/clear-all-cache` နှင့် `/clear` ကို `->middleware('auth')` ချည်ထားသည်။ လော့ဂ်အင်မဝင်ပဲ ခေါ်ရင် 302 redirect to login ဖြစ်မည်။

---

## ၃။ Browser စစ်ဆေးချက် (အတိုချုပ်)

- **Login page** (`/login`): 200။ CSS/JS/assets များ 200 ဖြစ်သင့်သည်။ (Production တွင် app2.js ဖယ်ပြီး deploy လုပ်ထားရင် "Livewire is not defined" မဖြစ်တော့ပါ။)
- **Root `/`:** လော့ဂ်အင်မဝင်ရင် 302 → `/login`။
- **Admin routes:** လော့ဂ်အင်မဝင်ရင် 302 → `/login`။

---

## ၄။ API စစ်ဆေးရန် cURL နမူနာများ

```bash
# 401
curl -s -o /dev/null -w "%{http_code}" -H "Accept: application/json" "https://cargo.shweyokelayexpress.com/api/v1/cargos"

# 422 (validation)
curl -s -o /dev/null -w "%{http_code}" -X POST -H "Accept: application/json" -H "Content-Type: application/json" \
  "https://cargo.shweyokelayexpress.com/api/v1/login" -d '{}'

# 404 (fake route)
curl -s -o /dev/null -w "%{http_code}" "https://cargo.shweyokelayexpress.com/no-such-route"

# 302 (web, no auth)
curl -s -o /dev/null -w "%{http_code}" "https://cargo.shweyokelayexpress.com/admin/cargos"
```

Deploy ပြီးပြီးချင်း ထို status များ ပြန်စစ်နိုင်ပါသည်။
