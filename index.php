<?php

/**
 * @author Muhammet Akkus <muhammetakkuss34@gmail.com>
 * @twitter twitter.com/muhammetakkuson
 * @package https://packagist.org/packages/cooky/url-router
 */


/*  */
require_once "vendor/autoload.php";

/* */
use Routy\Routy;

/* Routes */
Routy::get("/", function (){
    echo "<h2>home page</h2>";
});

/* Check URL == Router */
Routy::check();


/*
//ayrıca bu sayfalara erişim yanlızca admin oturum açmışsa olabilmeli ?? middleware?
Routy::group(['prefix' => 'admin'], function (){
    Routy::get('profile', 'CustomerPanel@profile'); // admin/profile
    Routy::get('dashboard', 'User@logout');			// admin/dashboard
});
*/

//it gonna add delete,put,any requests

//core.php -> calling() fonksiyonunda eğer Server::method() === $request koşulu return true yap else kısmını kaldır. çünkü koşul return ile sonlanmayınca aynı isimde gönderilen post ve get routerları çalışıp biri geçip çalışıyor diğeri geçmeyince else hatası ekrana basılıyor - yani else kalkıp fonks. return false dönsün koşuldan geçemediğinde. geçersede return true ver
//controller ve base_dir config olarak anasayfada tanımlanmalı $GLOBAL['config'] kullan $config['path']['controller'] = "x"
//csrf-token for post
//post form'da ve ajax'da csrf kullanımı readme
//packagist bunlarla yeni sürüm ekle