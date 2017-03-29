<?php

/**
 * Object Collection Interface
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
    public function getIterator();

    /**
     * @return mixed|null
     */
    public function getFirstItem();

    /**
     * Merge one collection into another
     *
     * @param ObjectCollectionInterface $collection
     * @return $this
     */
    public function merge(ObjectCollectionInterface $collection);

}