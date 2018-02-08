<?php namespace Routy;

class Config
{
    public $_path;
    public $_config_file;
    
    /* Loader ve Core, Config'i extends ediyor ve getConfigFile()'ı çalıştırıyor- */
    /* extends ettiği anda 2 şey oluyor. 1.si $_path ve $_config_file ve __constructure globalleri ateşleniyor */
    /* fakat bu değişkenler boş bu sebeple set işlemi ayrı bir fonksiyonda ve dosyada tutuluyor */
    /* ayrıca constructure'da config_file tanımlamasını yapmazsak */
    /* Loader ve Config  getConfigFile() istediği zaman $_config_file boş olur ve anlamsız olur */
    public function __construct()
    {
        return $this->_config_file = 'conf.php';
    }

    public function set(array $config)
    {
        $this->_path = $config;
        // $this->_config_file = trim($this->_path['config_path'], '/') . '/conf.php';        
        $this->setConfig();
    }
    
    public function getControllerPath()
    {
        $controller_path = trim($this->_path['controller'], '/') ?: 'controller/';
        return $controller_path . '/';
    }
    
    public function getViewPath()
    {
        $view_path = trim($this->_path['view'], '/') ?: 'view/';   
        return $view_path . '/';  
    }

    public function getConfigFile()
    {
        //return trim($this->_path['config_path'], '/');
        return $this->_config_file;
    }

    public function setConfig()
    {
        $file = fopen($this->_config_file, 'w') or die("fopen hata!!!");
        $write =  '<?php
                        return [
                            "controller" => "'.$this->getControllerPath().'",
                            "view" => "'.$this->getViewPath().'"
                    ];';
        fwrite($file, $write);
        fclose($file);
    }
}

/* return [
    'base_url' => 'localhost',
    'controller' => 'Controller',
    '404' => 'src'
]; */

// eşleşme olmazsa kök dizine gir config 404 keyinin valuesini al / lardan temizle ve içerisindeki 404.php te git
//     