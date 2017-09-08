<?php

namespace Routy;

class Server
{
    public static function domain()
    {
        return $_SERVER["SERVER_NAME"];
    }

    /**
     * if defined BASE_DIR return unbasedir uri
     * @return string
     */
    public static function uri()
    {
        $config = require 'config.php';
        $project_base = $config['path']['project_base_dir'];

        if (!empty($project_base))
        {
            $pars_full_uri = explode("/", ltrim($_SERVER["REQUEST_URI"], "/"));
            $pars_base_dir = explode("/", $project_base);

            $salt_uri = array_diff($pars_full_uri, $pars_base_dir);
            $salt_uri_implode = implode("/", $salt_uri);

            return $salt_uri_implode;
        }

        return ltrim($_SERVER["REQUEST_URI"], "/");
    }

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
}