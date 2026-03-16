# Admin Panel နှင့် API ပြန်စစ်ဆေးချက်

**စစ်ဆေးသည့်ရက်:** 2026-03-12  
**စစ်ဆေးသည့်နည်း:** Browser (Cursor IDE) + cURL (Production URL)

---

## ၁။ Admin Panel (Web)

| စစ်ဆေးချက် | ရလဒ် | မှတ်ချက် |
|--------------|--------|------------|
| **GET /** (လော့ဂ်အင်မဝင်) | **302** → `/login` | ✅ မှန်သည်။ |
| **GET /login** | **200** | ✅ Login စာမျက်နှာ ပေါ်သည်။ |
| **GET /admin/cargos** (လော့ဂ်အင်မဝင်) | **302** → login | ✅ Auth လိုသည်။ |
| **GET /forgot-password** | **200** | ✅ စာမျက်နှာ ပေါ်သည်။ |
| **POST /login** (CSRF မပါ) | **419** | ✅ CSRF token လိုသည် (ပုံမှန်)။ |
| **Browser console (Login စာမျက်နှာ)** | **"Livewire is not defined"** | ⚠️ Production မှာ login စာမျက်နှာက ယခုထိ **app2.js** load နေသေးသည်။ ကုဒ်ဘေ့စ်မှာ login/forgot/reset မှ app2.js ဖယ်ပြီး ပြင်ထားပြီး။ **Deploy ပြီးရင်** ဒီ error မပြတော့ပါ။ |

### Codebase ထဲက Admin ပြင်ဆင်ချက်များ (ပြီးသား)

- Login / Forgot Password / Reset Password မှ **app2.js** script ဖယ်ထားသည် (Livewire မသုံးသောကြောင့်)။
- Main layout (**app.blade.php**) မှာ **app2.js** ကို **@livewireScripts** ပြီးမှ load အောင် ပြောင်းထားသည်။
- **/clear-all-cache** နဲ့ **/clear** ကို **auth** middleware ချည်ထားသည်။

---

## ၂။ API

| Endpoint / အခြေအနေ | ရလဒ် | မှတ်ချက် |
|------------------------|--------|------------|
| **POST /api/v1/login** (မှားသော name/password) | **401** `{"success":false,"message":"Invalid credentials"}` | ✅ မှန်သည်။ |
| **POST /api/v1/login** (body ဗလာ) | **422** validation errors | ✅ မှန်သည်။ |
| **POST /api/v1/register** (invalid email/password) | **422** validation errors | ✅ မှန်သည်။ |
| **GET /api/v1/cargos** (token မပါ) | **401** `{"message":"Unauthenticated."}` | ✅ မှန်သည်။ |
| **GET /api/v1/cities** (token မပါ) | **401** | ✅ မှန်သည်။ |
| **GET /api/v1/cargo_types** (token မပါ) | **401** | ✅ မှန်သည်။ |
| **GET /api/v1/gates/1** (token မပါ) | **401** | ✅ မှန်သည်။ |
| **GET /api/v1/merchants** (token မပါ) | **401** | ✅ မှန်သည်။ |
| **GET /api/v1/cars** (token မပါ) | **401** | ✅ မှန်သည်။ |

### API အတွက် ကုဒ်ဘေ့စ်မှာ ပြီးသား

- Auth: login, register, logout။
- Protected routes အားလုံး **auth:sanctum** ချည်ထားသည်။
- 404/403/500 များ **sendError** နဲ့ မှန်ကန်စွာ ပြန်ထားသည်။
- Global exception handler မှ API အတွက် JSON + မှန်ကန်သော status code ပြန်သည်။

---

## ၃။ ချုပ်ချယ်ချက်

- **Production server** ပေါ်မှာ လက်ရှိ deploy လုပ်ထားတာက **အဟောင်း** ဖြစ်နေသေးရင် login စာမျက်နှာမှာ **app2.js** ဆ load နေပြီး **"Livewire is not defined"** ပြနေမည်။ ကုဒ်ဘေ့စ်ထဲက **resources/views/admin/auth/login.blade.php** (နဲ့ forgot-password, reset-password) ပြင်ဆင်ချက်ကို **deploy ပြီးရင်** ဒီ error ပျောက်မည်။
- **Admin panel** ကို လော့ဂ်အင်ဝင်ပြီး သုံးမယ်ဆိုရင် valid credentials နဲ့ **POST /login** (web form with CSRF) သုံးရပါမည်။
- **API** ကို Flutter / mobile ကနေ သုံးမယ်ဆိုရင် **POST /api/v1/login** နဲ့ token ယူပြီး **Authorization: Bearer &lt;token&gt;** ထည့်ခေါ်ရပါမည်။

---

## ၄။ ဆက်လုပ်ရန်

1. **ပြင်ဆင်ထားသော view နဲ့ route/API များကို production သို့ deploy ပြီး** login စာမျက်နှာ console error ပျောက်မမပျောက် ထပ်စစ်ပါ။  
2. လော့ဂ်အင်ဝင်ပြီး admin စာမျက်နှာများ (cargos, cities, reports စသည်) ဖွင့်စစ်ပါ။  
3. API token ယူပြီး **GET /api/v1/cargos**, **GET /api/v1/cities** စသည် ခေါ်စစ်ပါ။  

ဒီအတိုင်း deploy ပြီးရင် admin panel နဲ့ API နှစ်ခုလုံး အဆင်ပြေစွာ အလုပ်လုပ်မည် ဖြစ်ပါသည်။
