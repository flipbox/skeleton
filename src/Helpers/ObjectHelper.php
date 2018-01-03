<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Helpers;

use Flipbox\Skeleton\Exceptions\InvalidConfigurationException;
use Flipbox\Skeleton\Object\ObjectInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
class ObjectHelper
{
    /**
     * Returns the public member variables of an object.
     *
     * @param ObjectInterface $object
     * @return array
     */
    public static function getObjectVars(ObjectInterface $object)
    {
        return get_object_vars($object);
    }

    /**
     * Configures an object with the initial property values.
     *
     * @param ObjectInterface $object
     * @param $properties
     * @return ObjectInterface
     */
    public static function configure(ObjectInterface $object, $properties)
    {
        // Populate model attributes
        if (!empty($properties)) {
            // To array
            if (!is_array($properties)) {
                $properties = ArrayHelper::toArray($properties, [], false);
            }

            foreach ($properties as $name => $value) {
                if ($object->canSetProperty($name)) {
                    $object->$name = $value;
                }
            }
        }
        return $object;
    }

    /**
     * Create a new object
     *
     * @param $config
     * @param null $instanceOf
     * @return ObjectInterface
     * @throws InvalidConfigurationException
     */
    public static function create($config, $instanceOf = null)
    {
        // Closure check
        if (is_callable($config)) {
            return static::createFromCallable($config, $instanceOf);
        }

        // Get class from config
        $class = static::checkConfig($config, $instanceOf);

        // New object
        return new $class($config);
    }

    /**
     * Creates an object via a closure/callable
     *
     * @param callable $config
     * @param null $instanceOf
     * @return ObjectInterface
     * @throws InvalidConfigurationException
     */
    protected static function createFromCallable(callable $config, $instanceOf = null)
    {
        $object = call_user_func($config);

        if (!is_object($object)) {
            throw new InvalidConfigurationException(
                "Unable to create object class."
            );
        }

        if (!$object instanceof $instanceOf) {
            static::throwInvalidInstanceException(
                get_class($object),
                $instanceOf
            );
        }

        return $object;
    }

    /**
     * Checks the config for a valid class
     *
     * @param $config
     * @param null $instanceOf
     * @param bool $removeClass
     * @return null|string
     * @throws InvalidConfigurationException
     */
    public static function checkConfig(&$config, $instanceOf = null, $removeClass = true)
    {
        // Get class from config
        $class = static::getClassFromConfig($config, $removeClass);

        // Make sure we have a valid class
        if ($instanceOf && !is_subclass_of($class, $instanceOf)) {
            static::throwInvalidInstanceException($class, $instanceOf);
        }

        return $class;
    }

    /**
     * Get a class from a config
     *
     * @param $config
     * @param bool $removeClass
     * @return string
     * @throws InvalidConfigurationException
     */
    public static function getClassFromConfig(&$config, $removeClass = false)
    {
        // Find class
        $class = static::findClassFromConfig($config, $removeClass);

        if (empty($class)) {
            throw new InvalidConfigurationException(
                sprintf(
                    "The configuration must specify a 'class' property: '%s'",
                    JsonHelper::encode($config)
                )
            );
        }

        return $class;
    }

    /**
     * Find a class from a config
     *
     * @param $config
     * @param bool $removeClass
     * @return null|string
     */
    public static function findClassFromConfig(&$config, $removeClass = false)
    {
        // Normalize the config
        if (is_string($config)) {
            $class = $config;
            $config = '';
        } elseif (is_object($config)) {
            return get_class($config);
        } else {
            // Force Array
            if (!is_array($config)) {
                $config = ArrayHelper::toArray($config, [], false);
            }
            if ($removeClass) {
                if (!$class = ArrayHelper::remove($config, 'class')) {
                    $class = ArrayHelper::remove($config, 'type');
                }
            } else {
                $class = ArrayHelper::getValue(
                    $config,
                    'class',
                    ArrayHelper::getValue($config, 'type')
                );
            }
        }
        return $class;
    }

    /**
     * Throws an exception when an object is not of correct instance type
     *
     * @param $class
     * @param $instanceOf
     * @throws InvalidConfigurationException
     */
    protected static function throwInvalidInstanceException($class, $instanceOf)
    {
        throw new InvalidConfigurationException(
            sprintf(
                "The class '%s' must be an instance of '%s'",
                (string)$class,
                (string)$instanceOf
            )
        );
    }
}
