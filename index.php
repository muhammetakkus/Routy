<?php

/**
 * @author Muhammet Akkus <muhammetakkuss34@gmail.com>
 * @twitter twitter.com/muhammetakkuson
 * @package simple routing
 */


/* Autoloader */
require_once "vendor/autoload.php";

/* Namespaces */
use Routy\Routy;

/* Routes */
Routy::get("/", function (){
    echo "<h2>home page</h2>";
});

/* Check URL == Router */
Routy::check();


