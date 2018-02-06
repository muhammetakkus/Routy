<?php

namespace Routy;



class Core
{
    /**
     * @param $call
     * @return null
     */
    // bunu Helper'a taşı + gettype() kullanılabilir + function object olarak çıktı verir
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
    // bu method için naming refactor yapılacak
    public function handle($full_route, $route_data, $request)
    {
        /**
         * Helper::parse_route('user/{id}') => [$route, $param]
         */
        $route_with_params = Helper::parse_route($full_route); 

        /* parametre yok ise $params === NULL olur */
        list($route, $params) = $route_with_params;
        
        // list($route, $params) = explode("@", route_with_params); | $route = user | $params = ['id' => segment_sırası(1)]
        
        // eğer $param != NULL ise yani parametreli ise segment kontolü yapalım
        //$is_segment_equal = Helper::segment($full_route);
        
       /*  echo $route;
        echo PHP_EOL;
        echo Helper::uri();
         */
        /* PARAMETRELİ */
        //

        /* PARAMETRESİZ */
        if ($route === Helper::uri())
        {
            $this->calling($route_data, $route, $request, $params);
        }

        //if ($route === Helper::uri())
        //{
            // self::calling($route_data, $route, $request, $params);
        //}

        /*  legacy
            
            $unparams_router = implode(array_diff($pars_route, $params[0]), "/");

            gelen router'dan parametre sıralarını param_keys dizisine depola 
            $param_orders = array();
            foreach ($params[0] as $item) {
                $param_key = array_search($item, $pars_route);
                array_push($param_orders, $param_key);
            }

            yukarıda router'dan alınan parametre sıraları sayesinde uri'den parametreler param_values dizisine depolanıyor
            $param_values = array();
            foreach ($param_orders as $item)
            {
                array_push($param_values, $pars_uri[$item]);
            }

            parametreleri uri'den çıkart
            $unparams_uri = implode(array_diff($pars_uri, $param_values), "/");
        */
    }

    /**
     * @param $routes_data
     * @param $route
     * @param $request
     * @param array $param
     * @return bool
     */
    public function calling($routes_data, $route, $request, $param = [])
    {
        $this->check_http_request($request);

        if(is_callable($routes_data[$route]))
        {
            call_user_func($routes_data[$route]);
        }
        else
        {
            try{
                $this->run($routes_data, $route, $param);
            }catch (\Exception $e){
                echo $e->getMessage();
            }
        }

        return true;
    }

    /**
     * if class&method runned return true or throw $error
     *
     * @param $routes_data
     * @param $route
     * @param $param
     * @return bool|string
     */
    public function run($routes_data, $route, $param)
    {
        list($controller_name, $method) = explode("@", $routes_data[$route]);

        $this->callTheController($controller_name);

        if (class_exists($controller_name))
        {
            $controller_object = new $controller_name;

            if (method_exists($controller_name, $method))
            {
                call_user_func_array([$controller_object, $method], []);

                return true;
            }
            else
            {
                throw new \Exception("there isn't {$method} method in {$controller} class!");
            }
        }
        else
        {
            throw new \Exception("a class named {$controller} is not defined.");
        }

    }

    /**
     * 
     */
    public function check_http_request($request)
    {
        if (Helper::method() === $request)
        {
            return true;
        }

        die('invalid request ' . $request);
    }

    public function callTheController($controller_name)
    {
        $config = require 'Config.php';

        $controller_path = $config['controller'] . '/' . $controller_name . ".php";

        if (!file_exists($controller_path))
        {
            throw new \Exception("{$controller_path} file not created!");
            // die ('{$controller_path} Doesn\'t exist');
        }

        require_once $controller_path;
    }
}