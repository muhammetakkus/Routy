<?php

/**
 * @author Muhammet Akkus <muhammetakkuss34@gmail.com>
 * @twitter twitter.com/muhammetakkuson
 * @package simple routing
 */


require_once "vendor/autoload.php";


//\Routy\Routy::get("/", "Home@Index");
\Routy\Routy::get("/test/{id}", function ($id){
    echo $id;
});
var_dump(\Routy\Routy::get("/user/profile/{a}", "Home@Index"));

/*
Routy::get("/test-page",function (){
    echo "test page";
});

Routy::get("user/profile/{id}", "UserController@profile");

Routy::post("user/profile", "UserController@profile");*/

/**
 * route test-oop[PATTERNS]-module-github-packagist.org
 */

//interface abstract yapılarına bakılacak
//token method
//calling metod
//redirect metod


/*$url = parse_url($_SERVER['REQUEST_URI']);
echo $_SERVER['SERVER_NAME'];

public static function ajax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}
public static function uri()
{
    $url = parse_url($_SERVER['REQUEST_URI']);
    return $url['path'];
}
public static function method()
{
    return $_SERVER['REQUEST_METHOD'];
}
public static function domain()
{
    return $_SERVER['SERVER_NAME'];
}
public static function segment($index)
{
    $segments = self::segments();
    if (isset($segments[$index - 1])) {
        return $segments[$index - 1];
    } else {
        return null;
    }
}
public static function segments()
{
    return explode('/', trim(Request::uri(), '/'));
}*/