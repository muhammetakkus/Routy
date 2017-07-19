<?php

namespace Routy;

class Routy
{
    private static $_route;
    private static $_routes;
    private static $_controller;
    private static $_method;
    private static $_param;
    private static $_callback;
    private static $status = false;

    /**
     * @param $route static
     * @param $call static|closure
     */
    public static function get($route, $call)
    {
        /* is there closure function ? */
        self::$_callback = Core::callback($call);
        if (self::$_callback === null)
        {
            list(self::$_controller, self::$_method) = explode("@", $call);
        }

        /* is there parameters on URI */
        $is_param = Core::isParam($route);
        if($is_param === null)
        {
            /* eğer gelen rota parametresiz ise direk $_route'a al */
            /* eğer route '/' ise trimden geçince boş kalacağı için bunun kontrolünü yap - sıkıntı çıkardığı için kaldırdım */
            $route = trim($route, "/");
            ($route == "") ? self::$_route = "/" : self::$_route = $route;
        }
        else
        {
            list(self::$_route, self::$_param) = $is_param;
            self::$_param = trim(self::$_param, "/");
        }

        $data = array(
            'controller' => self::$_controller,
            'method' => self::$_method,
            'param' => array(self::$_param),
            'closure' => self::$_callback
        );

        /*
            [
                '/' => ['controller' => 'y', 'method' => 'z', 'param' => null, 'closure' => null],
                'test/user' => ['controller' => 'a', 'method' => 'b', 'param' => '2', 'closure' => null],
                ..
            ]
        */
        if(Core::getSaltUri(self::$_route) == true)
        {
            self::$_routes[self::$_route] = $data;
            Core::calling(self::$_routes, self::$_route);
            self::$status = true;
        }
        else
        {
            return false;
        }
    }

    /** POST **/
    public static function post($route, $call)
    {
        /* is there closure function ? */
        self::$_callback = Core::callback($call);

        /* eğer closure yoksa gelen Controller@Method 'u ayıkla */
        if (self::$_callback === null)
        {
            list(self::$_controller, self::$_method) = explode("@", $call);
        }

        /* get route */
        self::$_route = trim($route, "/");

        $data = array(
            'controller' => self::$_controller,
            'method' => self::$_method,
            'param' => self::$_param,
            'closure' => self::$_callback
        );

        /*
            [
                'x' => ['controller' => 'y', 'method' => 'z', 'param' => null, 'closure' => null],
                'test/user' => ['controller' => 'x', 'method' => 'y', 'param' => '2', 'closure' => null],
                ..
            ]
        */
        self::$_routes[self::$_route] = $data;

        return self::$_routes;
    }

    /**
     * check correct uri
     */
    public static function check()
    {
        if (self::$status === false)
        {
            //redirect home or 404
            echo "hiç olmayan router";
        }
    }

}