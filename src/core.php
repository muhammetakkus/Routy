<?php

namespace Routy;

class Core
{
    /**
     * @param $call
     * @return null
     */
    public static function callback($call)
    {
        if (is_callable($call))
        {
            return $call;
        }

        return null;
    }

    /**
     * @param $route
     * @param $route_data
     * @return bool
     */
    public static function isRoute($route, $route_data)
    {
        /* PARAMETRELİ */
        if(preg_match_all("@{(.*?)}@", $route, $params))
        {
            $parametre_keyleri = $params[1];

            /* o anki uri'yi parçala */
            $pars_uri = explode("/", Server::uri());
            //array_shift($pars_uri); //router 'ı uriden çıkart

            /* gelen router'ı parçala */
            $pars_route = explode("/", $route);

            //segment kontrolü - eğer pars_route ile pars_uri parça adedi denk ise işlem yap
            //bu sayede parametresiz router'ın aynısı parametreli şekilde gelince çakışmanın önüne geçiliyor
            if (count($pars_route) === count($pars_uri))
            {
                /* parametreleri router'dan çıkart */
                $unparams_router = implode(array_diff($pars_route, $params[0]), "/");

                /* gelen router'dan parametre sıralarını param_keys dizisine depola */
                $param_keys = array();
                foreach ($params[0] as $item) {
                    $param_key = array_search($item, $pars_route);
                    array_push($param_keys, $param_key);
                }

                /* yukarıda router'dan alınan parametre sıraları sayesinde uri'den parametreler param_values dizisine depolanıyor */
                $param_values = array();
                foreach ($param_keys as $item)
                {
                    if ($item <= count($pars_uri))
                    {
                        array_push($param_values, $pars_uri[$item]);
                    }
                }

                /* parametreleri uri'den çıkart */
                $unparams_uri = implode(array_diff($pars_uri, $param_values), "/");

                /* roter'dan preg ile çekilen parametreleri key ve uri'den parametre sırasına göre çekilen parametre değerlerinide value yap */
                $parameters = array_combine($params[1], $param_values);

                /* parametresiz router ile parametresiz uri denk ise controller çağrılsın */
                if ($unparams_router === $unparams_uri)
                {
                    if (self::calling($route_data, $route, $parameters) == true)
                        return true;
                    else
                        return false;
                }

            }
        }
        else
        {
            /* PARAMETRESİZ */

            $pars_current_uri = explode("/", Server::uri());
            //array_shift($pars_current_uri); //şu anki uri'yi almak için birinci klasör ismini çıkartıyoruz bu base name olayına ayar çekilecek
            $current_uri = implode($pars_current_uri, "/");

            /* Eğer uri boş ise -> / */
            if ($current_uri === "")
            {
                $current_uri = "/";
            }

            if ($route === $current_uri)
            {
                if (self::calling($route_data, $route) == true)
                    return true;
                else
                    return false;
            }
        }

        return false;
    }

    /**
     * @param $routes_data array
     * @param $route string
     * @param $param array
     * @return bool
     */
    public static function calling($routes_data, $route, $param = [])
    {
        if(is_callable($routes_data[$route]['call']))
        {
            call_user_func_array($routes_data[$route]['call'], $param);
        }
        else
        {
            list($controller, $method) = explode("@", $routes_data[$route]['call']);
            $controllerPath = "controller/" . strtolower($controller) . ".php";
            if (file_exists($controllerPath))
            {
                include $controllerPath;

                $controller = new $controller;
                call_user_func_array([$controller,$method], $param);
            }
        }

        return true;
    }

}