<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Object;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
interface ObjectInterface
{
    /**
     * Create and return a new object based on a config
     *
     * @param array $config
     * @return ObjectInterface
     */
    public static function create($config = []): ObjectInterface;

    /**
     * Returns a value indicating whether a property is defined.
     *
     * @param string $name
     * @param bool $checkVars
     * @return bool
     */
    public function hasProperty($name, $checkVars = true): bool;

    /**
     * Returns a value indicating whether a property can be read.
     *
     * @param string $name
     * @param bool $checkVars
     * @return bool
     */
    public function canGetProperty($name, $checkVars = true): bool;

    /**
     * Returns a value indicating whether a property can be set.
     *
     * @param string $name
     * @param bool $checkVars
     * @return bool
     */
    public function canSetProperty($name, $checkVars = true): bool;

    /**
     * Returns a value indicating whether a method is defined.
     *
     * @param string $name
     * @return bool
     */
    public function hasMethod($name): bool;
}
