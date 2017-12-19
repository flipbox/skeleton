<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Collections;

use Flipbox\Skeleton\Exceptions\InvalidCollectionItemException;
use Flipbox\Skeleton\Exceptions\InvalidConfigurationException;
use Flipbox\Skeleton\Helpers\ObjectHelper;
use Flipbox\Skeleton\Object\ObjectInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.1.0
 */
class ObjectCollection extends Collection implements CollectionInterface
{
    /**
     * @var string
     */
    public $instance = ObjectInterface::class;

    /**
     * @inheritdoc
     * @throws InvalidConfigurationException
     */
    public function init()
    {
        parent::init();

        if (!$this->instance) {
            throw new InvalidConfigurationException(
                sprintf(
                    "Object Collection must identify an object instance: '%s'",
                    $this->instance
                )
            );
        }
    }

    /**
     * @inheritdoc
     * @throws InvalidCollectionItemException
     */
    public function addItem($item)
    {
        // Validate instance
        if (!$item instanceof $this->instance) {
            $item = ObjectHelper::create(
                $item,
                $this->instance
            );
        }

        return parent::addItem($item);
    }
}
