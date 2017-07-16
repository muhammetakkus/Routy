<?php

/**
 * @author Muhammet Akkus <muhammetakkuss34@gmail.com>
 * @twitter twitter.com/muhammetakkuson
 * @package simple routing
 */


/* uri klasör ismini döndürmemeli */

use Routy\Routy;

require_once "vendor/autoload.php";


echo basename($_SERVER['REQUEST_URI']).PHP_EOL;


/* çalışmıyor?
Routy::get("/test/{user}", function ($user){
    echo $user;
});
 */

Routy::get("/user/", "Test@Index");


/* bu şekilde routerların olması çakışır
    yani 3 kısımlı bir routerdan -ilk 2 kısmının aynı oaln ve de parametre alan gibi benzeri varsa
    getSaltUri() fonksiyonu  */
//Routy::get("/user/profile/x", "Test@Index");
//Routy::get("/user/profil/{id}", "Home@Index");

/* var olan core.php deki match kontrolü yapılacak */
/* REQUEST kontrolü yapılacak get te istek get mi gibi */
/* dökümantasyonu yazılacak */
/* oop durumu incelenecek */

/**
 * route test-oop[PATTERNS]-module-github-packagist.org
 */

//interface abstract yapılarına bakılacak
//token method
//calling metod
//redirect metod