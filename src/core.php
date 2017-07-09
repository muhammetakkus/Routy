<?php

namespace Routy;

class Core
{
    private static $urim;
    private static $router;
    public static function callback($call)
    {
        if (is_callable($call))
        {
            return $call;
        }

        return null;
    }

    /*  eğer parametre varsa - bu preg, ilk süslü parantezi ve öncesini matchliyor
        yani iki parametre gönderildiği zaman match bozuluyor
        çoklu parametreli hali nasıl yapılır?
    */
    /**
     * @param $route user/profile/{id}
     * @return null | ["user/profile","2"] - uri'deki eşleşen route ile uride geriye kalan parametreyi döndürür
     */
    public static function isParam($route)
    {

        if (preg_match('/(.*)\{(.*)\}/', $route, $match))
        {
            //$match

            /* gelen route'daki parametrelerden ayıklanmış kısmı al-match[1]- ve trimle */
            self::$router = trim($match[1],"/");
            //(self::$router == "") ? self::$router = "/" : self::$router;
        }

        /* pars edilen o anki uri'yi slash ile birleştir */
        self::$urim = implode(URI::parsUri(), "/");
        //(self::$urim == "") ? self::$urim = "/" : self::$urim;

        /* gelen route'daki parametresiz kısmı uri'de ara ilk eşleşmeyi çıkart.
           eşleşen kısmı ve
           sona kalan kısmı-par- geri döndür */

        if (preg_match("@(". self::$router .")(.*)@", self::$urim, $r))
        {
            array_shift($r);
            return $r; //[route and param]
        }
    }

    public static function calling($route_bank, $route_key)
    {
        if ($route_bank[$route_key]['closure'] === null)
        {
            call_user_func_array($route_bank[$route_key]['closure'], $route_bank[$route_key]['param']);
        }
        else
        {
            /* [controller,method] */
            $call = array_shift($route_bank[$route_key]['controller'],$route_bank[$route_key]['method']);
            call_user_func_array($call, $route_bank[$route_key]['param']);
        }
    }
}