<?php

namespace Routy;

class Route
{

    /**
     * store routes and data
     */
    private static $_route;

    public static function __callStatic($type, $args)
    {
      if($type === 'get') {
        self::getx($args);
      }

      if($type === 'post') {
        self::postx($args);
      }

      if($type === 'delete') {
        self::deletex($args);
      }

      if($type === 'group') {
        self::groupx($args);
      }
    }

    public static function getx($args)
    {
        list($route, $call) = $args;

        $clean_route = Helper::clearRoute($route);

        self::$_route[$clean_route] = $call;

        $core = new Core();
        $core->handle($clean_route, self::$_route, 'GET');
    }

    public static function post($route, $call)
    {
        $clean_route = Helper::clearRoute($route);

        self::$_route[$clean_route] = $call;

        $core = new Core();
        $core->handle($clean_route, self::$_route, 'POST');
    }

    public static function delete($route, $call)
    {

    }

    public static function group($prefix, $call)
    {
        // self::get($prefix, $call);
    }

    public static function complete()
    {
      Helper::errorPage();
    }
}
