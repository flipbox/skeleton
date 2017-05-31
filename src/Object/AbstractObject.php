<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Object;

use Flipbox\Skeleton\Exceptions\InvalidCallException;
use Flipbox\Skeleton\Exceptions\UnknownMethodException;
use Flipbox\Skeleton\Exceptions\UnknownPropertyException;
use Flipbox\Skeleton\Helpers\ArrayHelper;
use Flipbox\Skeleton\Helpers\ObjectHelper;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
abstract class AbstractObject implements ObjectInterface
{
    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (!empty($config)) {
            ObjectHelper::configure($this, $config);
        }
        $this->init();
    }

    /**
     * @inheritdoc
     */
    public static function create($config = []): ObjectInterface
    {
        // Force array
        if (!is_array($config)) {
            $config = ArrayHelper::toArray($config, [], false);
        }

        // Add class to config
        $config['class'] = static::class;

        return ObjectHelper::create($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
    }

    /**
     * @inheritdoc
     */
    public function hasProperty($name, $checkVars = true): bool
    {
        return $this->canGetProperty($name, $checkVars) || $this->canSetProperty($name, false);
    }

    /**
     * @inheritdoc
     */
    public function canGetProperty($name, $checkVars = true): bool
    {
        return method_exists($this, 'get' . $name) || $checkVars && property_exists($this, $name);
    }

    /**
     * @inheritdoc
     */
    public function canSetProperty($name, $checkVars = true): bool
    {
        return method_exists($this, 'set' . $name) || $checkVars && property_exists($this, $name);
    }

    /**
     * @inheritdoc
     */
    public function hasMethod($name): bool
    {
        return method_exists($this, $name);
    }

    /**
     * Returns the value of an object property.
     *
     * @param $name
     * @return mixed
     * @throws InvalidCallException
     * @throws UnknownPropertyException
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (method_exists($this, 'set' . $name)) {
            throw new InvalidCallException('Getting write-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * Sets value of an object property.
     *
     * @param $name
     * @param $value
     * @throws InvalidCallException
     * @throws UnknownPropertyException
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (method_exists($this, 'get' . $name)) {
            throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * Checks if a property is set, i.e. defined and not null.
     *
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        } else {
            return false;
        }
    }

    /**
     * Sets an object property to null.
     *
     * @param $name
     * @throws InvalidCallException
     */
    public function __unset($name)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter(null);
        } elseif (method_exists($this, 'get' . $name)) {
            throw new InvalidCallException('Unsetting read-only property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * Calls the named method which is not a class method.
     *
     * @param $name
     * @param $params
     * @throws UnknownMethodException
     */
    public function __call($name, $params)
    {
        throw new UnknownMethodException('Calling unknown method: ' . get_class($this) . "::$name()");
    }
}
