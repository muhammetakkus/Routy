<?php

/**
 * @author Muhammet Akkus <muhammetakkuss34@gmail.com>
 * @twitter twitter.com/muhammetakkuson
 * @package simple routing
 */

use Routy\Routy;

require_once "vendor/autoload.php";

define("BASE_DIR", "");

Routy::get("/", function (){
    echo "<h2>home page</h2>";
});

Routy::get("admin/user/{id}/name/{username}", function ($id, $name){
    echo "Welcome to admin panel <b>" . $name . "</b> id = " . $id;
});

Routy::post("test/post/{id}", function ($id){
    echo $id;
});

Routy::check();
