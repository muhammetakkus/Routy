<?php

namespace Routy;



class Core
{
    /**
     * @param $full_route
     * @param $route_data
     * @param $request
     * @return mixed
     */
    public function handle($full_route, $route_data, $request)
    {
        $route_with_params = Helper::parse_route($full_route); 

        /* parametre yok ise [$params === false] olur */
        list($route_paramless, $params) = $route_with_params;

        /**
         *  PARAMETRELİ
         *  [$param != false] ise yani parametreli ise segment kontolü yap
         */
        if ($params)
        {
            $is_segment_equal = Helper::segment($full_route, $params);
            if ($is_segment_equal)
            {
                $real_params = Helper::getParams($full_route);
                
                $uri_paramless = $this->paramUriAndParamRouteIsEqual($real_params);
                
                if ($route_paramless === $uri_paramless)
                {
                    $this->run($route_data, $full_route, $real_params, $request);
                }
                
            }
        }

        /* PARAMETRESİZ */
        if (!$params && $route_paramless === Helper::uri())
        {
            $this->run($route_data, $route_paramless, [], $request);
        }
        
        /*  legacy

            gelen router'dan parametre sıralarını param_keys dizisine depola 
            $param_orders = array();
            foreach ($params as $item) {
                $param_key = array_search($item, $pars_route);
                array_push($param_orders, $param_key);
            }

            yukarıda router'dan alınan parametre sıraları sayesinde
            uri'den parametreler param_values dizisine depolanıyor
            $param_values = array();
            foreach ($param_orders as $item)
            {
                array_push($param_values, $pars_uri[$item]);
            }

            parametreleri uri'den çıkart
            $unparams_uri = implode(array_diff($pars_uri, $param_values), "/");
        */
    }

    public function paramUriAndParamRouteIsEqual($real_params)
    {
        /* parametreli route ve uri parametresiz olarak denk mi kontrol et */
        $param_string = implode('/', $real_params);
                
        if ($param_string === '')
        {
            $uri_paramless = Helper::uri();
        }else {
            $uri_paramless = explode($param_string, Helper::uri());
            $uri_paramless = $uri_paramless[0];
        }

        return $uri_paramless;
    }

    /**
     * @param $route_data
     * @param $route
     * @param $params
     * @param $request
     */
    public function run($route_data, $route, $params, $request)
    {
        
        $this->check_http_request($request);

        // burası gelen route callback mi string/controller mı diye bakılıp ona göre alttaki kısım çalıştırılmalı
        $this->runTheCallback($route_data, $route, $params);
        
        //
        list($controller_name, $method_name) = explode("@", $route_data[$route]);

        $this->callTheController($controller_name);

        $this->runTheController($controller_name, $method_name, $params);

        die();
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

    /**
     * must be refactor..
     */
    public function callTheController($controller_name)
    {
        $config = require 'Config.php';

        $controller_path = $config['controller'] . '/' . $controller_name . ".php";

        if (!file_exists($controller_path))
        {
            throw new \Exception("{$controller_path} file not created!");
            die ('{$controller_path} Doesn\'t exist');
        }

        require_once $controller_path;
    }

    /**
     * must be refactor..
     */
    public function runTheController($controller_name, $method_name, $params)
    {
        if (class_exists($controller_name))
        {
            $controller_object = new $controller_name;

            if (method_exists($controller_name, $method_name))
            {
                call_user_func_array([$controller_object, $method_name], $params);

                return true;
            }
            else
            {
                throw new \Exception('there isn\'t {$method} method in {$controller} class!');
            }
        }
        else
        {
            throw new \Exception('a class name {$controller} is not defined!');
        }

        die();
    }

    /**
     * 
     */
    public function runTheCallback($route_data, $route, $params)
    {
        if(is_callable($route_data[$route]))
        {
            call_user_func_array($route_data[$route], $params);
            die();
        }
    }
}