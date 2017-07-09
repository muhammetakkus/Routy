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
        return trim($_SERVER["REQUEST_URI"], "/");
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