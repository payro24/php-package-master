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
<div dir="rtl">

توجه داشته باشید فایل `index.php` و `verify.php` صرفا جهت تست و نمونه استفاده قرارداده شده است و شما بسته به نیاز پروژه به هرشکل که نیاز هست میتوانید از این پکیج استفاده کنید

#####متود های قابل استتفاده 

</div>

### index.php

```php 
    // جهت ایجاد تراکنش و دریافت شماره تراکنش از این متود استفاده میکنیم
    $payment = $payro->payment($callback, '123', 1000, 'name', 'mail@domain.com', 'mobile', 'desc');
    if ($payment) {
        // جهت انتقال کاربر به درگاه پرداخت از این متود استفاده کنید
        $payro->gotoPaymentPath();
    }
```

###verify.php

```php 
    //با استفاده از این متود میتوانید بررسی کنید که آیا اطلاعات برگشتی از پیرو دریافت شده یا خیر
     if ($payro->receiveData()) {
        //با استفاده از این متود میتوانید استعلام صحّت تراکنش جاری را دریافت کنید
        $receipt = $payro->inquiry($payro->getTrackId(), '123', 1000);
        echo json_encode($receipt);

    } else echo 'no data to validation';
```



