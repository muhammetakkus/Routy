<?php

namespace Routy;

class Routy
{
    private static $_routes;
    private static $_route;
    private static $_controller;
    private static $_method;
    private static $_param;
    private static $_callback;

    /** GET **/
    public static function get($route, $call)
    {
        /* is there closure function ? */
        self::$_callback = Core::callback($call);

        /* eğer closure yoksa gelen Controller@Method 'u ayıkla */
        if (self::$_callback === null)
        {
            list(self::$_controller, self::$_method) = explode("@", $call);
        }

        /* is there parameters on URI */
        $is_param = Core::isParam($route);

        /* eğer $is_param null değilse - parametre varsa */
        if($is_param !== null)
        {
           list(self::$_route, self::$_param) = $is_param;
           self::$_param = trim(self::$_param, "/");
        }
        else
        {
           /* eğer gelen rota parametresiz ise direk $_route'a al */
           /* eğer route '/' ise trimden geçince boş kalacağı için bunun kontrolünü yap */
           $route = trim($route, "/");
           ($route == "") ? self::$_route = "/" : self::$_route = $route;
        }

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
        //self::$_routes[self::$_route] = $data;


            return self::$_routes[self::$_route] = $data;
            //Core::calling(self::$_routes, self::$_route);

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

}