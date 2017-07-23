<?php

namespace Routy;

class Server
{
    public static function domain()
    {
        return $_SERVER["SERVER_NAME"];
    }

    public static function uri()
    {
        if (defined('BASE_DIR') && !empty(BASE_DIR))
        {
            echo "base dir var";
            $pars_full_uri = explode("/", ltrim($_SERVER["REQUEST_URI"], "/"));
            $pars_base_dir = explode("/", BASE_DIR);

            $salt_uri = array_diff($pars_full_uri, $pars_base_dir);
            $salt_uri = implode("/", $salt_uri);

            return $salt_uri;
        }

        return ltrim($_SERVER["REQUEST_URI"], "/");
    }

    public static function method()
    {
        return $_SERVER["REQUEST_METHOD"];
    }

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