<?php

namespace Joussin\Component\Configuration;

class Configuration extends \ArrayObject
{

    public function __construct($array = [])
    {
        parent::__construct($array, \ArrayObject::STD_PROP_LIST);
    }

    /**
     * <?php
     *  return [
     *      'key_1' => 'value_1',
     *  ];
     *
     */
    public static function from(string $path): self
    {
        try {
            return new self(require $path);
        } catch (\Exception $e) {
            throw new \Exception();
        }
    }

    public function has($key)
    {
        return $this->offsetExists($key);
    }


    public function get($key, $default = null)
    {
        return $this->gets($this->all(), $key, $default );
    }

    /**
     * Get the specified configuration value.
     *
     * @param $key
     * @param $default
     * @return mixed|null
     */
    public function gets($items, $key, $default = null)
    {
        if (! str_contains($key, '.')) {
            return $this->items[$key] ?? $default;
        }
        foreach (explode('.', $key) as $segment) {
            $items = $items[$segment] ?? $default;
            if (!is_array($items)) break;
        }
        return $items;
    }



    public function all()
    {
        return $this->getArrayCopy();
    }

    public function set($key, $value = null)
    {
        $this->offsetSet($key, $value);
    }

}