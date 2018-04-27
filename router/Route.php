<?php

namespace Routy;

class Route
{
    /**
     * store routes and data
     */
    private static $_route;

    /*
     * bu class üzerine gelen statik kullanımları yakalamak için
     * $request_method bu class üzerinde kullanılan methodun ismini alır
     */
    public static function __callStatic($request_method, $args)
    {
      //print_r($request_method);
      list($route, $call) = $args;

      $clean_route = Helper::clearRoute($route);

      self::$_route[$clean_route] = $call;



      $core = new Core();
      $core->handle($clean_route, self::$_route, strtoupper($request_method));
    }

    /*
    public static function get($route, $call)
    {
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
    */
    public static function complete()
    {
      Helper::errorPage();
    }
}
