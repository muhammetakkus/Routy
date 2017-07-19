<?php

/**
 * @author Muhammet Akkus <muhammetakkuss34@gmail.com>
 * @twitter twitter.com/muhammetakkuson
 * @package simple routing
 */


/* uri klasör ismini döndürmemeli */


use Routy\Routy;
use Routy\Server;

require_once "vendor/autoload.php";



echo "-".Server::uri()."-</br>";
Routy::get("/test/{user}", function ($user){
    echo $user;
});

Routy::get("/", function (){
   echo "home page--";
});
Routy::get("/user/", "Test@Index");

//parametrede sıkıntı var bak..
Routy::get("profile/{id}", "Home@Index");

Routy::check();

//eğer app dosyaları bir klasör içerisindeyse ana dizinde o klasör ismi request_uri olarak alınıyor
//localhost'da mecvuren bir klasör içerisinde
//o zaman şu olacak eğer bir klasör içerisindeyse o klasör ismi config dosyasında belirtilmeli

/* bu şekilde routerların olması çakışır
    yani 3 kısımlı bir routerdan -ilk 2 kısmının aynı oaln ve de parametre alan gibi benzeri varsa
    getSaltUri() fonksiyonu  */
//Routy::get("/user/profile/x", "Test@Index");
//Routy::get("/user/profil/{id}", "Home@Index");


/* dökümantasyonu yazılacak */
/* oop durumu incelenecek */
/* testleri yaz */

/**
 * route test-oop[PATTERNS]-module-github-packagist.org
 */

//interface abstract yapılarına bakılacak
//token method
//calling metod
//redirect metod