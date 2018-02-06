<?php

namespace Routy;

class Route
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
        $clean_route = Helper::clearRoute($route);
        
        /* yazılan rotanın tamamını, çağrılacak fonksiyonu ile array'a al ve Core.php'a gönder */
        self::$_routes[$clean_route] = $call;

        $core = new Core();
        $core->handle($clean_route, self::$_routes, 'GET');
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
            //echo "there isn't any router like this";
			return false;
		}
		
		return true;
    }

}