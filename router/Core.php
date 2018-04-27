<?php namespace Routy;

use Config\Config;

class Core
{
    /**
     * @param $full_route
     * @param $route_data
     * @param $request_method
     */
    public function handle($full_route, $route_data, $request_method)
    {
        $route_with_params = Helper::parse_route($full_route);

        /* parametre yok ise [$params === false] olur */
        list($route_paramless, $params) = $route_with_params;

        /**
         *  Parameterized
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
                    $this->run($route_data, $full_route, $real_params, $request_method);
                }
            }
        }

        /* Paramless */
        if (!$params && $route_paramless === Helper::uri())
        {
            $this->run($route_data, $route_paramless, [], $request_method);
        }
    }

    public function paramUriAndParamRouteIsEqual($real_params)
    {
        /* parametreli route =???= parametresiz uri  */
        $param_string = implode('/', $real_params);

        if ($param_string === '')
        {
            $uri_paramless = Helper::uri();
        } else {
            $uri_paramless = explode($param_string, Helper::uri());
            $uri_paramless = $uri_paramless[0];
        }

        return $uri_paramless;
    }

    /**
     * @param $route_data
     * @param $route
     * @param $params
     * @param $request_method
     */
    public function run($route_data, $route, $params, $request_method)
    {
        $check_request = $this->check_http_request($request_method);

        if($check_request)
        {
            if(gettype($route_data[$route]) === 'object') {
                $this->runTheCallback($route_data, $route, $params);
            }

            list($controller_name, $method_name) = explode('@', $route_data[$route]);
            $this->callTheController($controller_name);
            $this->runTheController($controller_name, $method_name, $params);
        }
    }

    /**
     *
     */
    public function check_http_request($request_method)
    {
        if (Helper::method() === $request_method) {
            return true;
        }
    }

    /**
     * @param $controller_name
     *
     * refactor!
     */
     public function callTheController($controller_name)
     {

        $controller_path = trim(Config::get('router.controller'), '/') . '/';

        /* Admin\Dashboard@panel */
        $sub_controller = explode('\\', $controller_name);
        if(count($sub_controller) > 1) {
            $sub_controller_path = '';
            foreach($sub_controller as $item) {
              $sub_controller_path .= $item . '/';
            }
            $controller_full_path =  $controller_path . rtrim($sub_controller_path, '/') . '.php';
       } else {
            $controller_full_path =  $controller_path . $controller_name . '.php';
       }

       if (!file_exists($controller_full_path))
       {
           die($controller_full_path.' file not created!');
       }

       require_once $controller_full_path;
     }

     /**
      *
      */
     public function runTheController($controller_name, $method_name, $params)
     {
       $sub_controller_name = explode('\\', $controller_name);
       if(count($sub_controller_name) > 1) {
         $controller_name = trim(end($sub_controller_name));
       }

       if (class_exists($controller_name))
       {
           $controller_object = new $controller_name();

           if (method_exists($controller_name, $method_name))
           {
               call_user_func_array([$controller_object, $method_name], $params);
               die();
           }

           die('there isn\'t '.$method_name.' method in '.$controller_name.' class!');
       }

       die('class name '.$controller_name.' is not defined!');
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
