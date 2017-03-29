<?php

/**
 * Abstract Object
 *
 * @package    Skeleton
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 *
 * @link       https://github.com/flipbox/skeleton
 * @since      1.0.0
 */

namespace flipbox\skeleton\object;

interface ObjectInterface
{

    /**
     * Create and return a new object based on a config
     *
     * @param array $config
     * @return ObjectInterface
     */
    public static function create($config = []);

    /**
     * Returns the fully qualified name of this class.
     *
     * @return string
     */
    public static function className();

    /**
     * Returns a value indicating whether a property is defined.
     *
     * @param string $name
     * @param bool $checkVars
     * @return bool
     */
    public function hasProperty($name, $checkVars = true);

    /**
     * Returns a value indicating whether a property can be read.
     *
     * @param string $name
     * @param bool $checkVars
     * @return bool
     */
    public function canGetProperty($name, $checkVars = true);

    /**
     * Returns a value indicating whether a property can be set.
     *
     * @param string $name
     * @param bool $checkVars
     * @return bool
     */
    public function canSetProperty($name, $checkVars = true);

    /**
     * Returns a value indicating whether a method is defined.
     *
     * @param string $name
     * @return bool
     */
    public function hasMethod($name);

}
