<?php

namespace Routy;

class URI
{

    public static function parsUri()
    {
        /* Get Full URL (with root directory) */
        $full_uri = explode("/", strtolower(Server::uri()));

        /**
         * uri, localde klasörün ismi ile birlikte dönüyor.
         * Klasör ismini uri'den çıkartmak için bu işlemler.
         * Dizin ile alınan uride eşleşen kayıt varsa çıkartılıyor.
         */
        $match_dir = array_intersect(self::getRootDir(), $full_uri);
        $match_dir = implode("", $match_dir);
        $match_key = array_search($match_dir, $full_uri);
        unset($full_uri[$match_key]);

        return array_values($full_uri);
    }

    public static function getRootDir()
    {
        $real_path = trim(strtolower(realpath('.')), "/");
        return explode(DIRECTORY_SEPARATOR, $real_path);
    }
}