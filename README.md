# Payro24
payro24 payment gateway package for php

<div dir="rtl">
جهت استفاده از این پکیج شما باید ابتدا دستور زیر رو اجرا کنید
</div>

```bash
$ composer install
```

<div dir="rtl">

جهت کانفیگ اولیه به دایرکتوری `payro` و سپس فایل `RestService.php`مراجعه کنید.
</div>

```php 
    protected $sandBox = false; //حالت تست یا به اصطلاح سندباکس
    protected $apiKey = 'xxxx-xxxx-xxxx-xxxx'; // کلید دریافتی از سامانه پیرو
```