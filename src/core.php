<?php

namespace Routy;

class Core
{
    private static $urim;
    private static $router;
    private static $currentRouter;
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

        return null;
    }

    public static function calling($route_bank, $route_key)
    {
        if ($route_bank[$route_key]['closure'] === null)
        {
            $controllerPath = "controller/" . strtolower($route_bank[$route_key]['controller']) . ".php";
            if (file_exists($controllerPath))
            {
                include $controllerPath;

                $controller = new $route_bank[$route_key]['controller'];
                $method = $route_bank[$route_key]['method'];

                call_user_func_array([$controller,$method], $route_bank[$route_key]['param']);
            }
        }
        else
        {
            call_user_func_array($route_bank[$route_key]['closure'], $route_bank[$route_key]['param']);
        }
    }

    public static function getSaltUri($route)
    {
        if ($route === "/" && Server::uri() === "/")
        {
            return true;
        }
        /* şu an parametreli routerlar için routerdan parametreyi atıp uri'de eşleştiriyor
            ancak parametresi girildiğinde son kısım farklı olduğu için(parametresi) uri ile eşleşmiyor
            eğer parametreli ise ayrı bir preg yapılmalı yani aşağıdaki $saltUri preg'i bu if'in else koşulu için
        yani parametresiz routerlar için uygun. parametreli için yapılacak pregde son kısım aynı olmalı koşulmayacak ve
            uride match olan ksıımdan geriye kalan parametre olacak- zaten sadece true dönse yeter */
        if (preg_match('/(.*)\{(.*)\}/', $route, $m))
        {
            self::$currentRouter = trim($m[1], "/");

            $pattern = "@.*(".self::$currentRouter.")@u";
            if (preg_match($pattern, Server::uri(), $saltUri))
            {
                return true;
            }
        }
        else
        {
            self::$currentRouter = $route;

            $pattern = "@.*(".self::$currentRouter.")$@u";
            if (preg_match($pattern, Server::uri(), $saltUri))
            {
                /*var_dump($saltUri);*/
                return true;
            }
        }

        return false;
        //$pattern = '@.*('. self::getSaltRouter() .')$@';
        //$match = preg_split($pattern, $rt);
/*
        $current_salt_uri = self::getSaltRouter();
        var_dump($current_salt_uri);*/


        //istenen uri 'ninde bu kısmı varsa eşleşsin ve uriden bu kısım alınsın bu eşleşme
        //bağımsız olarak çalışıyor. buraya self::$currentRouter 'de geliyor ancak burada match yapmıyor?
    }
}