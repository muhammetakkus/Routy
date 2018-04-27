<?php namespace Routy;

use Config\Config;

class Helper
{
    public static $full_route;
    public static $parameters;

    public static function parse_route(string $full_route): array
    {
         if(preg_match("@{.*}@", $full_route, $params))
         {
             self::$parameters = self::clear($params[0]);
         } else {
            self::$parameters = false;
         }

         /**
          * split route
          * user/{id} -> user bu user/ olsa da route ile match etsek
          */
         $paramless_route = preg_split('@{(.*)}@', $full_route);
         $paramless_route = $paramless_route[0];

         $_routes = [$paramless_route, self::$parameters];

         return $_routes;

         /* bu pattern sadece en son parametre ile match oluyor bütün parametrelerle match olması için nasıl olmalıydı?
         if(preg_match_all("@(.*){(?:.*)}@", $full_route, $paramless_route, 2))
         {
            var_dump($paramless_route);
         } */
    }

    /**
     * Slashlardan temizlenmiş parametreli URI ile
     * Slashlardan temizlenmiş parametreli roter'ı pars eder
     * segment kontrolünü yapar eğer segmentler eşit ise route ile uri adedi eşit
     * ve parametreler alınıp run edilebilir demektir
     */
    public static function segment($full_route, $params)
    {
        /* parametreli route'ın parametresiz hali */
        $route_without_param = explode($params, $full_route);

        $pars_route = explode("/", $full_route);

        $uri = self::uri() === '/' ? '' : self::uri();
        $pars_uri = explode("/", $uri);

        $uri_segment = count($pars_uri);
        $route_segment = count($pars_route);

        if ($uri_segment === $route_segment)
        {
            return true;
        }

        return false; // redirect 404 - olmaz bu sefer üst sırada olan ve segment uymayan rota çalışır 404 gider?
    }

    public static function getParams($mock_params)
    {
        $parse_mock_params = explode('/', $mock_params);
        $pars_uri = explode("/", self::uri());

        $real_params = array_diff($pars_uri, $parse_mock_params);

        return $real_params;
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
    public static function is_ajax()
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
         // host/user?name=qwe
         $uri = explode('?', $uri)[0];
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

    public static function errorPage()
    {
      $path_404 = realpath('.') . '/' . trim(Config::get('view.404'), '/');

      if(!file_exists($path_404))
        echo 'Page Not Found';

      require_once $path_404;
      echo ob_get_clean();
      die();
    }
}
