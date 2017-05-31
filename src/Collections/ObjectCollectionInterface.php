<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Collections;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
interface ObjectCollectionInterface extends \IteratorAggregate
{
    /**
     * Add an item to the current data items
     *
     * @param array $items
     */
    public function setItems($items = []);

    /**
     * Add an item to the current data items
     *
     * @param $item
     */
    public function addItem($item);

    /**
     * @param null $indexBy
     * @return array|\Traversable
     */
    public function getItems($indexBy = null);

    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator;

    /**
     * @return mixed|null
     */
    public function getFirstItem();

    /**
     * Merge one collection into another
     *
     * @param ObjectCollectionInterface $collection
     * @return static
     */
    public function merge(ObjectCollectionInterface $collection);
}
