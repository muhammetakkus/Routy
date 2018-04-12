<?php namespace Config;

/**
 *
 */
class ConfigFile
{

  const CONFIG_FILE_PATH = 'configs';

  public static function getConfigFilePath($page)
  {
    $file_path = __DIR__ . '/' . self::CONFIG_FILE_PATH . '/'. $page . '.php';

    if(file_exists($file_path)) {
      return $file_path;
    }

    return 'sayfa bulunamadı-> ' . $file_path;
  }

  // asıl config arrayını return eder
  public static function getConfigArray($page)
  {
    $array = include(self::getConfigFilePath($page));
    return $array;
  }
}
