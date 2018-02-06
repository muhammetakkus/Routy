<?php

namespace Routy;

class Helper
{
    public static $full_route;
    public static $parameters;
    public static function parse_route($full_route)
    {
        // gelen router parametreli mi değil mi kontrol edilir
        // $_val[$router] => $params[] şeklinde gönderilir - bu daha uygun nasıl gönderilir?
        /**
         * preg_match_all php 7 ile gelen fonksiyonuna bak
         * array_diff
         * strpos 
         * strstr
         */

         // temizle + parametresiz ise uri ile match et
         // temizle + parametreli ise parametrelerinden soy + temizle + uri ile match et
    
         static::$full_route = $full_route;

         /**
          * match parameters
          * user/{id} -> {id}
          */
         if(preg_match("@{.*}@", static::$full_route, $params))
         {
             //$params = $params[1]; // test/{id}/{id2} => [id, id2]
             self::$parameters = self::clear($params[0]);
         }
         
         /**
          * split route
          * user/{id} -> user bu user/ olsa da route ile match etsek
          */
         $paramless_route = preg_split('@{(.*)}@', static::$full_route);
         $paramless_route = $paramless_route[0];
         
         //echo $paramless_route;
         $_routes = [$paramless_route, self::$parameters];
        
         return $_routes;

         /* bu pattern sadece en son parametre ile match oluyor bütün parametrelerle match olması için nasıl olmalıydı?
         if(preg_match_all("@(.*){(?:.*)}@", static::$full_route, $paramless_route, 2))
         {
            var_dump($paramless_route);
         } */
         
         // şu şekilde bir rotanın patterni nasıl yazılır
         /* admin/user/{id}/name/{username} */
    }
    
    /**
     * Slashlardan temizlenmiş parametreli URI ile
     * Slashlardan temizlenmiş parametreli rota'nın segment kontrolünü yapar
     */
    public static function segment($full_route)
    {
        /** */
        $pars_uri = explode("/", self::uri());
        $pars_route = explode("/", $full_route);

        $uri_segment = count($pars_uri);
        $route_segment = count($pars_route);

      
        echo "uri: " . $uri_segment;
        echo PHP_EOL;
        echo "route: " . $route_segment;

        if ($uri_segment === $route_segment)
        {
            return true;
        }

        return false; // redirect 404 olmaz bu sefer üst sırada olan ve segment uymayan rota çalışır 404 gider?
    }

    /**
     * @return string
     */
    public static function method()
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    /**
     * @return bool
     */
    public static function isAjax()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
        {
            return true;
        }

        return false;
    }

    /**
     * url den URI al ve temizlenmiş hali ile return et
     */
    public static function uri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        return self::clearURI($uri);
    }

    // gelen router trim yapılıp gönderilir parametrelerde sadece trim içindir
        // user/{id}/ -> user/{id}
    public static function clearRoute($value)
    {
        if ($value === '/' || $value === '')
        {
            return '/';
        }

        $lastCharacter = substr($value, -1);
        if ($lastCharacter === '/')
        {
            return trim($value, '/') . '/'; // ltrim($value, '/') aynı işi görmez mi?
        }

        return trim($value, '/');
    }

    // gelen uri / veya '' ise return /
    // son karakteri / ise ltrim yapılır
    // son karakteri / değil ise trim yapılır
    public static function clearURI($value)
    {
        if ($value === '/' || $value === '')
        {
            return '/';
        }

        $lastCharacter = substr($value, -1);
        if ($lastCharacter === '/')
        {
            return trim($value, '/') . '/'; // ltrim($value, '/') aynı işi görmez mi?
        }

        return trim($value, '/');
    }

    public static function clear($value)
    {
        return trim($value, '/');
    }
}