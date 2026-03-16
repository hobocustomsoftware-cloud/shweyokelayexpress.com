# API & Browser စစ်ဆေးချက် အစီရင်ခံစာ

**စစ်ဆေးသည့်ရက်:** 2026-03-12  
**စစ်ဆေးသည့်နည်း:** Production URL + Browser (Cursor IDE Browser) + cURL

---

## ၁။ API စစ်ဆေးချက်

### စမ်းသပ်ခဲ့သော Endpoint များ

| Endpoint | Method | ရလဒ် | မှတ်ချက် |
|----------|--------|--------|------------|
| `/api/v1/login` | POST | ✅ JSON `{"success":false,"message":"Invalid credentials"}` | Wrong credentials နဲ့ စမ်းခဲ့သည်။ အဆင်ပြေသည်။ |
| `/api/v1/cargo_types` | GET (no auth) | ✅ `{"message":"Unauthenticated."}` | Auth လိုအပ်ကြောင်း မှန်ကန်စွာ ပြန်သည်။ |
| `/api/v1/register` | POST | ❌ Server Error | Production တွင် error ဖြစ်နေခဲ့သည်။ |

### ပြင်ဆင်ပြီးအရာများ (Register API)

- **ပြဿနာ:** Register ခေါ်တိုင်း Server Error (500) ပြန်နေခဲ့သည်။ (Role မရှိခြင်း / exception စသည် ဖြစ်နိုင်သည်။)
- **ပြင်ဆင်ချက်:** `AuthApiController::register()` ထဲတွင် `try/catch` ထည့်ပြီး exception ဖြစ်ပါက log ရိုက်ကာ `{"success":false,"message":"Registration failed. Please try again."}` ပြန်စေသည်။ Response ကို user object အပြည့်အစား မပြန်တော့ဘဲ `id`, `name`, `email` ပဲ ပြန်သည်။

**မှတ်ချက်:** Production server ပေါ်တွင် `User` role ရှိ/မရှိ စစ်ပြီး လိုအပ်ရင် `php artisan db:seed --class=RoleSeeder` ပြေးပေးပါ။

---

## ၂။ Browser (Login စာမျက်နှာ) စစ်ဆေးချက်

### တွေ့ရသော Bug

- **Console error:** `Uncaught ReferenceError: Livewire is not defined` (app2.js, line 429)
- **အကြောင်းရင်း:** Login / Forgot Password / Reset Password စာမျက်နှာတွင် Livewire component မသုံးထားပါ။ သို့သော် `app2.js` ကို load ထားသောကြောင့် app2.js ထဲက `Livewire.hook` / `Livewire.find` စသည်တို့ run သောအခါ Livewire မရှိသေးသဖြင့် error ဖြစ်သည်။

### ပြင်ဆင်ပြီးအရာများ

1. **Login, Forgot Password, Reset Password**  
   - ထို auth စာမျက်နှာ ၃ ခုမှ `app2.js` script tag ကို ဖယ်ပြီးပါပြီ။ (Livewire မသုံးသော စာမျက်နှာတွင် app2.js မလိုအပ်ပါ။)

2. **Main layout (app.blade.php)**  
   - `app2.js` ကို `<head>` မှ ဖယ်ပြီး `@livewireScripts` **ပြီးသည့်နောက်** `<body>` အဆုံးတွင် load အောင် ပြောင်းထားပါသည်။ ထိုသို့ပြောင်းခြင်းဖြင့် Livewire load ပြီးမှ app2.js run မည်ဖြစ်ပြီး အခြား admin စာမျက်နှာများတွင် "Livewire is not defined" ထပ်မဖြစ်အောင် ကာကွယ်ထားသည်။

---

## ၃။ Local Server (မစတင်နိုင်ခြင်း)

- **အမှား:** `php artisan serve --port=8765` ပြေးသောအခါ  
  `Call to undefined function Illuminate\Support\mb_split()`  
- **အကြောင်းရင်း:** PHP `mbstring` extension မလုပ်နေသော environment (သို့) PHP version ကွဲနေသော environment ဖြစ်နိုင်သည်။
- **အကြံပြုချက်:**  
  - `php -m` ဖြင့် `mbstring` ပါ/မပါ စစ်ပါ။  
  - လိုအပ်ပါက `sudo apt install php-mbstring` (သို့) သင့် OS နဲ့ PHP version နဲ့ ကိုက်သော mbstring ထည့်ပါ။  
  - `php artisan serve` ကို ထို PHP နဲ့ပဲ ပြေးပါ။

---

## ၄။ ဆက်လုပ်ရန်

1. **ပြင်ဆင်ထားသော code များကို deploy ပြီး** production တွင် login စာမျက်နှာ ပြန်ဖွင့်စစ်ပါ။ Console မှာ "Livewire is not defined" မပါတော့သင့်ပါ။  
2. **Register API** ကို ပြန် စမ်းပါ။ မအောင်မြင်ပါက server log (`storage/logs/laravel.log`) ထဲတွင် "API Register error" ကြည့်ပြီး Role / DB စသည်ကို စစ်ပါ။  
3. **Local** တွင် mbstring ပြဿနာ ဖြေပြီး `php artisan serve` နဲ့ local မှ API များ ထပ်စမ်းနိုင်ပါသည်။
