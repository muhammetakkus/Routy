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
     * @param $request
     * @return bool
     */
    public static function isRoute($route, $route_data, $request)
    {
        /* PARAMETRELİ */
        if(preg_match_all("@{(.*?)}@", $route, $params))
        {
            $pars_uri = explode("/", Server::uri());

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

                /* roter'dan preg ile çekilen parametreleri keylerini, uri'den parametre sırasına göre çekilen parametre değerleri ile combinle */
                $parameters = array_combine($params[1], $param_values);

                /* parametresiz router ile parametresiz uri denk ise controller çağrılsın */
                if ($unparams_router === $unparams_uri)
                {
                    if (self::calling($route_data, $route, $request, $parameters) == true)
                        return true;
                    else
                        return false;
                }

            }
        }
        else
        {
            /* PARAMETRESİZ */
            $current_uri = Server::uri();

            /* Eğer uri boş ise -> / */
            if ($current_uri === "")
            {
                $current_uri = "/";
            }

            if ($route === $current_uri)
            {
                if (self::calling($route_data, $route, $request) == true)
                    return true;
                else
                    return false;
            }
        }

        return false;
    }

    /**
     * @param $routes_data
     * @param $route
     * @param $request
     * @param array $param
     * @return bool
     */
    public static function calling($routes_data, $route, $request, $param = [])
    {
        if (Server::method() === $request)
        {
            if(is_callable($routes_data[$route]['call']))
            {
                call_user_func_array($routes_data[$route]['call'], $param);
            }
            else
            {
                self::run($routes_data, $route, $param);
            }
        }
        else
        {
            echo "invalid request";
        }

        return true;
    }

    /**
     * @param $routes_data
     * @param $route
     * @param $param
     * @return bool|string if class&method runned return true or return $error
     */
    public static function run($routes_data, $route, $param)
    {
        list($controller, $method) = explode("@", $routes_data[$route]['call']);

        $controllerPath = "controller/" . $controller . ".php";

        if (file_exists($controllerPath))
        {
            require_once $controllerPath;

            if (class_exists($controller))
            {
                $controller_object = new $controller;

                if (method_exists($controller, $method))
                {
                    call_user_func_array([$controller_object,$method], $param);

                    return true;
                }
                else
                {
                    $error = "there isn't {$method} method in {$controller} class!";
                }
            }
            else
            {
                $error = "a class named {$controller} is not defined.";
            }
        }
        else
        {
            $error = "{$controllerPath} file not created!";
        }

        echo $error;
    }

}