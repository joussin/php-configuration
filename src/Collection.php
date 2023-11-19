<?php

namespace Joussin\Component\Support;

class Collection extends \ArrayObject
{

    public function __construct($items = [])
    {
        parent::__construct($items, \ArrayObject::ARRAY_AS_PROPS);
    }

    public function all()
    {
        return $this->getArrayCopy();
    }

    public function add($item)
    {
        $this->append($item);
    }

    public function push(...$items)
    {
        foreach ($items as $item)
        {
            $this->append($item);
        }
    }


    public function at($at)
    {
        return $this->offsetGet($at);
    }


    public function isEmpty()
    {
        return $this->count() == 0;
    }


    public function search($item, $strict = false)
    {
        return array_search($item, $this->all(), $strict);
    }


}