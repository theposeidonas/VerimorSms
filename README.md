<a name="readme-top"></a>
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]




<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://istanbulwebtasarim.pro">
    <img src="https://istanbulwebtasarim.pro/images/istanbul-web-tasarim-logo.webp" alt="İstanbul Web Tasarım" style="width: 40%">
  </a>

<h3 align="center">Verimor SMS Laravel Package</h3>

[![Laravel][Laravel.com]][Laravel-url]
![Packagist Downloads (custom server)][downloads-url]


  <p align="center">
    Laravel için yazılmış Verimor üzerinden SMS gönderimi ve kalan kredi sorgulama paketi.
    <br />
    <a href="https://github.com/theposeidonas/VerimorSms"><strong>Dökümantasyon »</strong></a>
    <br />
    <br />
    <a href="https://github.com/theposeidonas/VerimorSms">Demo</a>
    ·
    <a href="https://github.com/theposeidonas/VerimorSms/issues">Buglar</a>
    ·
    <a href="https://github.com/theposeidonas/VerimorSms/issues">İstekler</a>
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>İçindekiler</summary>
  <ol>
    <li>
      <a href="#about-the-project">Proje Hakkında</a>
    </li>
    <li>
      <a href="#getting-started">Başlarken</a>
      <ul>
        <li><a href="#prerequisites">İhtiyaçlar</a></li>
        <li><a href="#installation">Projenize Ekleme</a></li>
      </ul>
    </li>
    <li><a href="#usage">Kullanım</a></li>
    <li><a href="#license">Lisans</a></li>
    <li><a href="#contact">İletişim</a></li>
  </ol>
</details>


## Proje Hakkında

VerimorSms Laravel için oluşturulmuş kolayca SMS gönderme sağlayan bir pakettir. Ayrıca kalan kredilerinizi kontrol ederek kolayca projenizde yazdırabilirsiniz.

Neden ihtiyaç var:
* Verimor için tekrar tekrar helper fonksiyonları yazmanıza gerek kalmaz.
* Verimor'un verdiği tüm fonksiyonlara erişim sağlar

Sadece basit bir kaç komut ile projenize dahil edebilir, fonksiyonları kullanarak basit SMS gönderimi yapabilirsiniz.

<p align="right">(<a href="#readme-top">Başa dön</a>)</p>


## Başlarken

Kullanacağınız proje Laravel projesi olmalıdır. Kurulumu yaptıktan sonra composer ile projenize ekleyebilirsiniz. 

### İhtiyaçlar

Laravel versiyonu 7 veya daha güncel olmalıdır. Verimor paneli üzerinden paketi kullanacağınız sunucu veya yerel IP & DNS'leri kaydetmelisiniz. SMS Hizmeti > SMS Ayarları kısmından bu değişiklikleri yapabilirsiniz. SSL sertifika kontrolü açık olmalıdır.

Ayrıca API erişimi seçeneği de açık olmalıdır. SMS mesajlarını test ederken aynı numaraya defalarca aynı SMS'i atıyorsanız, Mükerrer SMS Gönderimi açık olmalıdır.

### Projenize ekleme

Laravel projenizde terminali açarak şu komutu çalıştırın;

```shell
composer require theposeidonas/verimor-sms
```

Eğer gerekiyorsa config dosyasını paylaşmak için şu komutu çalıştırın;

```shell
php artisan vendor:publish --tag=verimor-config --force
```

Sonrasında Verimor'u her yerde kullanmak için config/app.php dosyasında 'aliases' kısmına şu kodu ekleyin;

```php
'Verimor' => Theposeidonas\VerimorSms\Facades\Verimor::class,
```

### Konfigürasyon

Kullanım için projenize eklemeyi yaptıktan sonra, .env dosyası içerisinde yukarıya şu satırı ekleyip düzeltmelisiniz;
```dotenv
VERIMOR_USERNAME=908501234567  // API Kullanıcı adı
VERIMOR_PASSWORD=XXXXXXXXX  // API şifreniz
VERIMOR_TITLE=XXXXXX  // SMS Gönderim başlığı (0850XXXXXXX şeklinde numaranız varsayılan başlığınızdır)
```
<p align="right">(<a href="#readme-top">Başa dön</a>)</p>


## Kullanım

Kullanacağınız Controller içerisine paketi dahil etmeniz gerekiyor;

```php   
use Theposeidonas\VerimorSms\Facades\Verimor;
```

Tüm ayarlamaları ve konfigürasyonlarınızı yaptıktan sonra kullanacağınız Controller içerisine şu fonksiyonları çalıştırabilirsiniz;
```php
// Kalan kredi kontrolü
$request = Verimor::checkCredit();
$request->credit; // (int) 9999 veya (string) Kullanıcı adı ve şifre geçersiz.
$request->status; // (int) 200 veya (int) 401

// SMS gönderimi (POST)
$request = Verimor::send('Mesajınız', '905312345678');
$request->message; // (string) 20210 veya (string) INSUFFICIENT_CREDITS 
$request->status; // (int) 200 veya (int) 400

// SMS gönderimi (GET)
$request = Verimor::sendGet('Mesajınız', '905312345678');
$request->message; // (string) 20210 veya (string) INSUFFICIENT_CREDITS 
$request->status; // (int) 200 veya (int) 400

// Ekstra parametreler ile SMS gönderimi (POST)
$parameters = [
'source_addr' => 'YENI BASLIK', // Kayıtlı diğer başlıklarınızdan
'valid_for' => '24:00', // SMS geçerlilik saati, SS:DD şeklinde veya S:DD şeklinde
'send_at' => '', // 2023-12-20 16:30:00 şeklinde datetime veya boş
'custom_id' => uniqid(), // Kampanya ID
'datacoding' => 0 // Datacoding
];

$request = Verimor::send('Mesajınız', '905312345678', $parameters);
$request->message; // (string) 20210 veya (string) INSUFFICIENT_CREDITS 
$request->status; // (int) 200 veya (int) 400
```
<p align="right">(<a href="#readme-top">Başa dön</a>)</p>

<!-- LICENSE -->
## Lisanslama

MIT Lisansı altında dağıtılmaktadır. Daha fazla bilgi için 'LICENSE' dosyasına bakın.

<p align="right">(<a href="#readme-top">Başa dön</a>)</p>



<!-- CONTACT -->
## İletişim

Baran Arda - [@theposeidonas](https://twitter.com/theposeidonas) - info@baranarda.com

Proje Linki: [https://github.com/theposeidonas/VerimorSms](https://github.com/theposeidonas/VerimorSms)

<p align="right">(<a href="#readme-top">Başa dön</a>)</p>


<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/theposeidonas/VerimorSms.svg?style=for-the-badge
[contributors-url]: https://github.com/theposeidonas/VerimorSms/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/theposeidonas/VerimorSms.svg?style=for-the-badge
[forks-url]: https://github.com/theposeidonas/VerimorSms/network/members
[stars-shield]: https://img.shields.io/github/stars/theposeidonas/VerimorSms.svg?style=for-the-badge
[stars-url]: https://github.com/theposeidonas/VerimorSms/stargazers
[issues-shield]: https://img.shields.io/github/issues/theposeidonas/VerimorSms.svg?style=for-the-badge
[issues-url]: https://github.com/theposeidonas/VerimorSms/issues
[license-shield]: https://img.shields.io/github/license/theposeidonas/VerimorSms.svg?style=for-the-badge
[license-url]: https://github.com/theposeidonas/VerimorSms/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/theposeidonas/
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[downloads-url]: https://img.shields.io/packagist/dt/theposeidonas/verimor-sms?style=for-the-badge&color=007ec6&cacheSeconds=3600