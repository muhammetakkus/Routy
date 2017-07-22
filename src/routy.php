<?php

namespace Routy;

class Routy
{
    /**
     * @var $_routes string stored routes and data
     */
    private static $_routes;

    /**
     * @var bool route verify
     */
    private static $status = false;

    /**
     * @param $route string
     * @param $call
     */
    public static function get($route, $call)
    {
        if ($route != "/")
        {
            $route = trim($route, "/");
        }

        $data = array(
            'call' => $call
        );

        self::$_routes[$route] = $data;

        if (Core::isRoute($route, self::$_routes) === true)
        {
            self::$status = true;
        }
    }

    /**
     * check correct uri
     */
    public static function check()
    {
        if (self::$status === false)
        {
            echo "page not found - redirect 404.php";
        }
    }

}