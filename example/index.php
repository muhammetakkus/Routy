<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

/*  */
require '../vendor/autoload.php';

/* CONFIG */
use Routy\Config;
(new Config())->set([
    //'config_path' => 'config',
    //'404' => 'view/error',
    'controller' => 'Controller',
    'view' => ''
]);

use Routy\Route;
Route::get('/', 'Home@Index');

/* will do */
// 404_path alınacak ve medhod() === 404 ise 404 yönlendirmesi yapılacak
// config dosyası alternatif çözüm veya conf.php'i cachele - şu anki halinde config dosyası her sayfa yenilemede config classının çalıştırılması ile yeniden rewirete oluyor.
// config dosyası için alternatif path - veya şu an App ana dizininde oluşturulan conf.php vendorde kendi içinde olsun?
// callback fonksiyonunda $this->view('main'); şeklinde kullanım olsun
// parametre almayan fonksiyona parametre gönderilince hata vermiyor - bu bir sorun mu?
// user/{name}/id/{id} formatı  +  bunun regexp'i nasıl yazılır - şu an bu kullanım desteklenmiyor - sadece parametreler sonran kesiliyor