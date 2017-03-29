<?php

/**
 * Object Collection
 *
 * @package    Skeleton
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 *
 * @link       https://github.com/flipbox/skeleton
 * @since      1.0.0
 */

namespace flipbox\skeleton\collections;

use flipbox\skeleton\exceptions\InvalidCollectionItemException;
use flipbox\skeleton\helpers\ArrayHelper;
use flipbox\skeleton\object\AbstractObject;
use flipbox\skeleton\object\ObjectInterface;

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
     * @return $this
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
     * @return $this
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
    public function getIterator()
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
     * @return $this
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
