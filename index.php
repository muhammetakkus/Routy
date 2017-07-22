<?php

/**
 * @author Muhammet Akkus <muhammetakkuss34@gmail.com>
 * @twitter twitter.com/muhammetakkuson
 * @package simple routing
 */

use Routy\Routy;

require_once "vendor/autoload.php";

Routy::get("/", function (){
    echo "<h2>home page</h2>";
});

Routy::get("user/profile/{id}", "Home@Index");

Routy::get("admin/user/{id}/name/{username}", function ($id, $name){
    echo "Welcome to admin panel <b>" . $name . "</b> id = " . $id;
});

Routy::check();

