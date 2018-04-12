<?php namespace Config;

class Config
{
    public static function get($key)
    {
        return (new Repository())->get($key);
    }
}