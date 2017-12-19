<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Collections;

use Flipbox\Skeleton\Error\ErrorTrait;
use Flipbox\Skeleton\Model\ModelInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 * @method ModelInterface[] getItems($indexBy = null)
 * @deprecated
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
