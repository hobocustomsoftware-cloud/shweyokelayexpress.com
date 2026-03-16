# PHP DOMDocument Error ဖြေရှင်းနည်း

`php artisan serve` ပြေးတိုင်း **Class "DOMDocument" not found** ပြနေပါက PHP မှာ **DOM/XML** extension မပါသေးခြင်း ဖြစ်ပါသည်။

## ဖြေရှင်းနည်း

Terminal မှာ အောက်က command တစ်ခုကို ပြေးပါ (PHP version က 8.4 ဖြစ်သည်ဟု ယူဆထားပါသည်)။

### Ubuntu / Debian

```bash
sudo apt-get update
sudo apt-get install php8.4-xml
```

PHP 8.2 / 8.3 သုံးနေရင် နာမည်ပြောင်းပါ။ ဥပမာ:

```bash
sudo apt-get install php8.2-xml
# သို့မဟုတ်
sudo apt-get install php-xml
```

### ပြီးရင် စစ်ပါ

```bash
php -m | grep dom
```

`dom` ပါလာရင် အောင်မြင်ပါပြီ။ ထို့နောက်:

```bash
cd /home/htoo-myat-eain/Downloads/cargo.shweyokelayexpress.com
php artisan serve
```

အဆင်ပြေပါသည်။
