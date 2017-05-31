<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Collections;

use Flipbox\Skeleton\Exceptions\InvalidCollectionItemException;
use Flipbox\Skeleton\Helpers\ArrayHelper;
use Flipbox\Skeleton\Object\AbstractObject;
use Flipbox\Skeleton\Object\ObjectInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
abstract class AbstractObjectCollection extends AbstractObject implements ObjectCollectionInterface
{
    /**
     * The item instance class
     */
    const ITEM_CLASS_INSTANCE = ObjectInterface::class;

    /**
     * A collection of items.
     *
     * @var array|\ArrayIterator
     */
    protected $_items = [];

    /*******************************************
     * ITEMS
     *******************************************/

    /**
     * Add an item to a collection
     *
     * @param $item
     * @return static
     * @throws InvalidCollectionItemException
     */
    public function addItem($item)
    {
        // Item class instance
        $itemInstance = static::ITEM_CLASS_INSTANCE;

        // Validate instance
        if ($itemInstance && !$item instanceof $itemInstance) {

            throw new InvalidCollectionItemException(
                sprintf(
                    "Unable to add item to collection because it must be an instance of '%s'",
                    static::ITEM_CLASS_INSTANCE
                )
            );

        }

        $this->_items[] = $item;

        return $this;
    }

    /**
     * @param array $items
     * @return static
     */
    public function setItems($items = [])
    {
        $this->_items = [];

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
        return $this->_items;
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
     * @param ObjectCollectionInterface $collection
     * @return static
     */
    public function merge(ObjectCollectionInterface $collection)
    {
        $this->_items = array_merge(
            $this->getItems(),
            $collection->getItems()
        );

        return $this;
    }
}
