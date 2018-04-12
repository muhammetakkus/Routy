<?php namespace Config;

// şu an get() ve all() kullanımda
// set faaliyete geçmeli

class Repository
{
    /**
     * All of the configuration items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new configuration repository.
     *
     * @param  array  $items
     * @return void
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        if (is_null($key)) {
            return false;
        }

        //ConfigFile::getConfigArray($key);
    }

    /**
     * Get the specified configuration value.
     *
     * @param  array|string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get($key)
    {
        /*if (is_array($key)) {
            return $this->getMany($key);
        }*/

        $configArray = ConfigFile::getConfigArray($this->getPageKey($key));

        if ($this->items === []) {
            return $configArray[$this->getConfigKey($key)];
        }

        //
        return $this->items[$key];
    }

    /**
     * Get many configuration values.
     *
     * @param  array  $keys
     * @return array
     */
    public function getMany($keys)
    {
        $config = [];

        foreach ($keys as $key => $default) {
            if (is_numeric($key)) {
                list($key, $default) = [$default, null];
            }

            $config[$key] = Arr::get($this->items, $key, $default);
        }

        return $config;
    }

    /**
     * Set a given configuration value.
     *
     */
    public function set($key, $value = null)
    {
        $configArray = $this->getAll($key);

        foreach ($configArray as $k => $v)
            if($k == $this->getConfigKey($key))
                $configArray[$k] = $value;
            else
                $configArray[$k] = $v;

        $this->items = $configArray;
    }

    /**
     * Get all of the configuration items for the application.
     *
     * @return array
     */
    public function getAll($key)
    {
        $configArray = ConfigFile::getConfigArray($this->getPageKey($key));
        return $configArray;
    }

    /**
     * Get all of the configuration items for the application.
     *
     * @return array
     */
    public function all(string $page): array
    {
        if (is_null($page)) {
            return [];
        }

        $config = ConfigFile::getConfigArray($page);

        if (is_array($config)) {
            return $config;
        }

        return ['there isn\'t '.$page.' config'];
    }

    /**
     *
     */
    public function extractConfig($key)
    {
        $key = explode('.', $key);
        return $key;
    }

    /**
     *
     */
    public function getPageKey($key)
    {
        return $this->extractConfig($key)[0];
    }

    /**
     *
     */
    public function getConfigKey($key)
    {
        return $this->extractConfig($key)[1];
    }
}
