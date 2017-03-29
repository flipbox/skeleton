<?php

/**
 * Model Collection
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

use flipbox\skeleton\error\ErrorTrait;
use flipbox\skeleton\model\ModelInterface;

/**
 * Class AbstractModelCollection
 * @package flipbox\skeleton\collections
 *
 * @method ModelInterface[] getItems($indexBy = null)
 */
abstract class AbstractModelCollection extends AbstractObjectCollection implements ModelCollectionInterface
{

    use ErrorTrait {
        getErrors as _traitGetErrors;
        clearErrors as _traitClearErrors;
    }

    /**
     * The item instance class
     */
    const ITEM_CLASS_INSTANCE = ModelInterface::class;


    /*******************************************
     * AGGREGATE ERRORS
     *******************************************/

    /**
     * Merge errors from all
     * @inheritdoc
     */
    public function getErrors($attribute = null)
    {

        $itemErrors = [];

        foreach ($this->getItems() as $item) {

            if ($item->hasErrors($attribute)) {

                $itemErrors[$this->getItemId($item)] = $item->getErrors($attribute);

            }

        }

        return array_merge(
            $this->_traitGetErrors($attribute),
            $itemErrors
        );

    }

    /**
     * @inheritdoc
     */
    public function clearErrors($attribute = null)
    {

        foreach ($this->getItems() as $item) {

            $item->clearErrors($attribute);

        }

        $this->_traitClearErrors($attribute);

    }

    /**
     * Get a unique Id for an object
     *
     * @param $item
     * @return string
     */
    protected function getItemId($item)
    {
        return spl_object_hash($item);
    }

}