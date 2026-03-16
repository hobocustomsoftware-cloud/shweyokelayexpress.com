# Migration ဖန်တီးနည်း (Prompt Error ရှိရင်)

`php artisan make:migration` ပြေးတိုင်း **stty: invalid argument** / **RuntimeException** ပြနေပါက terminal က interactive prompt ကို မလုပ်နိုင်လို့ ဖြစ်ပါတယ်။

## ဖြေရှင်းနည်း

Migration **နာမည်ကို command မှာ ထည့်ပြီး** ခေါ်ပါ။ ဒီလို ခေါ်ရင် မေးခွန်း မမေးတော့ပါ။

### ဥပမာ

**ဇယားအသစ် ဖန်တီးမယ်:**
```bash
php artisan make:migration create_products_table
```

**ကော်လံ ထပ်ထည့်မယ်:**
```bash
php artisan make:migration add_status_to_orders_table
```

**ဇယားနာမည် ပြောင်းမယ်:**
```bash
php artisan make:migration rename_old_table_to_new_table
```

### မှတ်ချက်

- နာမည်ကို **snake_case** သုံးပါ (ဥပမာ `create_users_table`, `add_email_to_users_table`)။
- `shweyoke_cargo_db` လို DB နာမည် မထည့်ပါနဲ့။ migration နာမည်က **ဘာ လုပ်မလဲ** ကို ဖော်ပြတဲ့ စာသား ဖြစ်ရပါမယ်။

### ပြေးပြီးရင်

ဖိုင်ကို **database/migrations/** အောက်မှာ ဖန်တီးပေးမယ်။ ဖိုင်ဖွင့်ပြီး `up()` နဲ့ `down()` ထဲမှာ လိုတဲ့ table / column ပြင်ဆင်ပါ။ ပြီးရင်:

```bash
php artisan migrate
```
