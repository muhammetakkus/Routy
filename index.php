<?php

/**
 * @author Muhammet Akkus <muhammetakkuss34@gmail.com>
 * @twitter twitter.com/muhammetakkuson
 * @package simple routing
 */

use Routy\Routy;

require_once "vendor/autoload.php";

define("BASE_DIR", "routy");

Routy::get("/", function (){
    echo "<h2>home page</h2>";
});

//bunlar her türlü çakışır - bu kullanımdan korun! bu durumda 2 side match olacak ve çalışacak
Routy::get("user/profile/{id}", "Home@Index");
Routy::get("user/profile/x", "Test@Index");


Routy::get("admin/user/{id}/name/{username}", function ($id, $name){
    echo "Welcome to admin panel <b>" . $name . "</b> id = " . $id;
});

Routy::check();




/* dökümantasyonu yazılacak */
/* oop durumu incelenecek */
/* testleri yaz */

/**
 * route test-oop[PATTERNS]-module-packagist.org
 */

//interface abstract yapılarına bakılacak
//token method
//calling metod
//redirect metod