<?php

namespace Joussin\Component\Configuration;

class FileConfig extends Config
{

    protected $package_path;
    protected $app_path;

    public $config_file_path;

    public function __construct(string $package_path, string $app_path)
    {
        $this->package_path = $package_path;
        $this->app_path = $app_path;

        $items = $this->mergeConfigFile($package_path, $app_path);

        parent::__construct($items);

        $this->publishConfigFile();
    }

    /**
     * <?php
     *  return [
     *      'key_1' => 'value_1',
     *  ];
     *
     */
    public function itemsFromConfigFile(string $path): array
    {
        try {
            return require $path;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function mergeConfigFile(string $package_path, string $app_path)
    {
        $this->config_file_path = $this->getConfigFilePath($package_path, $app_path);
        return $this->itemsFromConfigFile($this->config_file_path);
    }


    public function getConfigFilePath(string $package_path, string $app_path, string $default = '')
    {
        return file_exists($app_path) ? $app_path : (file_exists($package_path) ? $package_path : $default);
    }


    public function publishConfigFile() : void
    {
       try{
           if (!file_exists($this->package_path) || file_exists($this->app_path) ) { /** from not found OR to already exists */ }
           elseif(@copy($this->package_path, $this->app_path)) { /** success */ }
           else  { /** error */ }
       }
       catch (\Exception $e){}
    }
}