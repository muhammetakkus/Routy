<?php

namespace Routy;

class Routy
{
    /**
     * stored routes and data
     * @var $_routes string
     */
    private static $_routes;

    /**
     * for route verify
     * the controller is called if url matches the route and $status turned true
     * @var bool
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

        /*$data = array(
            'call' => $call
        );*/

        self::$_routes[$route] = $call;

        if (Core::isRoute($route, self::$_routes, "GET") === true)
        {
            self::$status = true;
        }
    }

    /**
     * @param $route string
     * @param $call
     */
    public static function post($route, $call)
    {
        if ($route != "/")
        {
            $route = trim($route, "/");
        }

        /*$data = array(
            'call' => $call
        );*/

        self::$_routes[$route] = $call;

        if (Core::isRoute($route, self::$_routes, "POST") === true)
        {
            self::$status = true;
        }
    }

    /**
     * check correct router
     */
    public static function check()
    {
        if (self::$status === false)
        {
            echo "there isn't any router like this";
        }
    }

}