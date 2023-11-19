<?php

namespace Joussin\Component\Configuration;



trait ConfigKeyAs
{


    public function merge($keys = [])
    {
        $all = $this->items;

        foreach ($keys as $key)
        {
            $all  = array_merge($all, $this->get($key));
            unset($all[$key]);
        }

        return $all;
    }



    /**
     * @param array|string $key
     * @return array|mixed|null
     */
    public function without($key, $entries = null)
    {
        $entries = $entries ?? $this->all();

        $keys = is_array($key) ? $key : [$key];
        $withoutKeys = array_diff(array_keys($entries), $keys);
        return $this->get($withoutKeys);
    }


    /**
     * $this->getKeys(['JWT_CONFIG', 'DS_CONFIG'], $GLOBALS)
     *
     *
     * @param $key
     * @param $entries
     * @return array|mixed|null
     */
    public function getKeys($key, $entries = null)
    {
        $entries = $entries ?? $this->all();
        $entriesKeys = array_keys($entries);

        $keys = is_array($key) ? $key : [$key];
        $withKeys = array_values(array_intersect($entriesKeys, $keys));

        return $this->get($withKeys);
    }


    public function setKeys($keys = [], $entries = null)
    {
        $entries = $entries ?? $this->all();

        foreach ($keys as $key)
        {
            $entries[$key] = $this->get($key);
        }
    }


    public function setKeysAsGlobal($keys = [])
    {
        foreach ($keys as $key)
        {
            $GLOBALS[$key] = $this->get($key);
        }
    }


    public function unsetKeys($keys = [])
    {
        foreach ($keys as $key)
        {
            $this->unset($key);
        }
    }

    public function unset($key)
    {
        unset($this->items[$key]);
    }



    public static function has_($array, $keys)
    {
        $keys = (array) $keys;

        if (! $array || $keys === []) {
            return false;
        }
        foreach ($keys as $key) {
            $subKeyArray = $array;
            if (isset($array[$key])) {
                continue;
            }
            foreach (explode('.', $key) as $segment) {
                if (isset($subKeyArray[$segment])) {
                    $subKeyArray = $subKeyArray[$segment];
                }
                else {
                    return false;
                }
            }
        }
        return true;
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




//    public function setWith($key, $value = null)
//    {
//        $key = $this->parseKey($key);
//
//        if (is_array($key)) {
//            $this->setKeyAsKeys($key, $value);
//        } else {
//            $this->items[$key] = $value;
//        }
//    }


//    private function parseKey(string $key, $separator = '.')
//    {
//        $keys = str_contains($key, $separator) ? explode($separator, $key) : null;
//        return (is_array($keys) && count($keys) > 1) ? $keys : $key;
//    }

//    private function setKeyAsKeys($keys = [], $value = null): void
//    {
//        $res = array_walk($this->items,
//            array($this, 'walk_recursive'),
//            [$keys, $value, 0, $this->items]
//        );
//    }



//    private function walk_recursive(&$item, string $key, array $args)
//    {
//        $keys = $args[0];
//        $value = $args[1];
//        $current_key_index = $args[2];
//        $listItems = $args[3];
//
//        $lastIndex = count($keys) - 1;
//        $lastKey = $keys[$lastIndex];
//
//        if ($key == in_array($key, $keys)) {
//            if ($key == $lastKey) {
//                $item = $value;
//            } elseif (is_array($item)) {
//                $current_key_index = $current_key_index + 1;
//                array_walk($item, array($this, 'walk_recursive'), [$keys, $value, $current_key_index, $listItems]);
//            }
//        }
//    }




}