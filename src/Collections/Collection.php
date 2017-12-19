<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Collections;

use Flipbox\Skeleton\Helpers\ArrayHelper;
use Flipbox\Skeleton\Object\AbstractObject;
use Flipbox\Skeleton\Object\ObjectInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.1.0
 */
class Collection extends AbstractObject implements CollectionInterface
{
    /**
     * A collection of items.
     *
     * @var array|\ArrayIterator
     */
    protected $items = [];

    /*******************************************
     * ITEMS
     *******************************************/

    /**
     * Add an item to a collection
     *
     * @param $item
     * @return static
     */
    public function addItem($item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param array $items
     * @return static
     */
    public function setItems($items = [])
    {
        $this->items = [];

        // Make sure we can iterate over it
        if (!is_array($items) && !$items instanceof \Traversable) {
            $items = [$items];
        }

        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * @param null $indexBy
     * @return ObjectInterface[]
     */
    public function getItems($indexBy = null)
    {
        return $this->items;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        $items = $this->getItems();

        if ($items instanceof \ArrayIterator) {
            return $items;
        }

        return new \ArrayIterator($items);
    }

    /**
     * @return mixed|null
     */
    public function getFirstItem()
    {
        if ($items = $this->getItems()) {
            return ArrayHelper::getFirstValue($items);
        }

        return null;
    }


    /*******************************************
     * MERGE
     *******************************************/

    /**
     * Merge one collection into another
     *
     * @param CollectionInterface $collection
     * @return static
     */
    public function merge(CollectionInterface $collection)
    {
        $this->items = array_merge(
            $this->getItems(),
            $collection->getItems()
        );

        return $this;
    }
}
