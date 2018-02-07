<?php

namespace Routy;

class Route
{

    /**
     * store routes and data
     */
    private static $_route;

    /**
     * @param $route string
     * @param $call
     */
    public static function get($route, $call)
    {
        $clean_route = Helper::clearRoute($route);
        
        /* yazılan rotanın tamamını, çağrılacak fonksiyonu ile array'a al ve Core.php'a gönder */
        self::$_route[$clean_route] = $call;

        $core = new Core();
        $core->handle($clean_route, self::$_route, 'GET');
    }

    /**
     * @param $route string
     * @param $call
     */
    public static function post($route, $call)
    {
        $clean_route = Helper::clearRoute($route);
        
        /* yazılan rotanın tamamını, çağrılacak fonksiyonu ile array'a al ve Core.php'a gönder */
        self::$_route[$clean_route] = $call;

        $core = new Core();
        $core->handle($clean_route, self::$_route, 'POST');
    }
}