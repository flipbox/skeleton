<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Helpers;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
class ArrayHelper
{
    /**
     * Builds a map (key => value) from a multidimensional array or an array of objects.
     *
     * @param $array
     * @param string|\Closure $from
     * @param string|\Closure $to
     * @param string|\Closure|null $group
     * @return array
     */
    public static function map($array, $from, $to, $group = null)
    {
        $result = [];
        foreach ($array as $element) {
            $key = static::getValue($element, $from);
            $value = static::getValue($element, $to);
            if ($group !== null) {
                $result[static::getValue($element, $group)][$key] = $value;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Merges two or more arrays into one recursively.
     *
     * @param $a
     * @param $b
     * @return array
     */
    public static function merge($a, $b)
    {
        $args = func_get_args();
        $res = array_shift($args);
        while (!empty($args)) {
            $next = array_shift($args);
            foreach ($next as $k => $v) {
                if (is_int($k)) {
                    if (isset($res[$k])) {
                        $res[] = $v;
                    } else {
                        $res[$k] = $v;
                    }
                } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                    $res[$k] = self::merge($res[$k], $v);
                } else {
                    $res[$k] = $v;
                }
            }
        }

        return $res;
    }

    /**
     * Checks if the given array contains the specified key.
     *
     * @param $key
     * @param $array
     * @param bool $caseSensitive
     * @return bool
     */
    public static function keyExists($key, $array, $caseSensitive = true)
    {
        if ($caseSensitive) {
            return array_key_exists($key, $array);
        } else {
            foreach (array_keys($array) as $k) {
                if (strcasecmp($key, $k) === 0) {
                    return true;
                }
            }

            return false;
        }
    }

    /**
     * Indexes an array according to a specified key.
     *
     * @param $array
     * @param $key
     * @return array
     */
    public static function index($array, $key)
    {
        $result = [];
        foreach ($array as $element) {
            $value = static::getValue($element, $key);
            $result[$value] = $element;
        }

        return $result;
    }

    /**
     * Converts an object or an array of objects into an array.
     *
     * @param $object
     * @param array $properties
     * @param bool $recursive
     * @return array
     */
    public static function toArray($object, $properties = [], $recursive = true)
    {
        if (is_array($object)) {
            if ($recursive) {
                foreach ($object as $key => $value) {
                    if (is_array($value) || is_object($value)) {
                        $object[$key] = static::toArray($value, $properties, true);
                    }
                }
            }

            return $object;
        } elseif (is_object($object)) {
            if (!empty($properties)) {
                $className = get_class($object);
                if (!empty($properties[$className])) {
                    $result = [];
                    foreach ($properties[$className] as $key => $name) {
                        if (is_int($key)) {
                            $result[$name] = $object->$name;
                        } else {
                            $result[$key] = static::getValue($object, $name);
                        }
                    }

                    return $recursive ? static::toArray($result, $properties) : $result;
                }
            }

            $result = [];
            foreach ($object as $key => $value) {
                $result[$key] = $value;
            }

            return $recursive ? static::toArray($result) : $result;
        } else {
            return [$object];
        }
    }

    /**
     * Retrieves the value of an array element or object property with the given key or property name.
     *
     * @param $array
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public static function getValue($array, $key, $default = null)
    {
        if ($key instanceof \Closure) {
            return $key($array, $default);
        }

        if (is_array($key)) {
            $lastKey = array_pop($key);
            foreach ($key as $keyPart) {
                $array = static::getValue($array, $keyPart);
            }
            $key = $lastKey;
        }

        if (is_array($array) && array_key_exists($key, $array)) {
            return $array[$key];
        }

        if (($pos = strrpos($key, '.')) !== false) {
            $array = static::getValue($array, substr($key, 0, $pos), $default);
            $key = substr($key, $pos + 1);
        }

        if (is_object($array)) {
            return $array->$key;
        } elseif (is_array($array)) {
            return array_key_exists($key, $array) ? $array[$key] : $default;
        } else {
            return $default;
        }
    }

    /**
     * Removes an item from an array and returns the value.
     *
     * @param $array
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public static function remove(&$array, $key, $default = null)
    {
        if (is_array($array) && (isset($array[$key]) || array_key_exists($key, $array))) {
            $value = $array[$key];
            unset($array[$key]);

            return $value;
        }

        return $default;
    }

    /**
     * Returns the first value in a given array.
     *
     * @param $arr
     * @return mixed
     */
    public static function getFirstValue($arr)
    {
        if (count($arr)) {
            if (isset($arr[0])) {
                return $arr[0];
            } else {
                $keys = array_keys($arr);

                return $arr[$keys[0]];
            }
        }
        return null;
    }


    /**
     * Finds matching values from two arrays
     *
     * @param array $keys
     * @param array $array
     * @return array
     */
    public static function matches($keys = [], $array = []): array
    {
        if (!empty($keys) && !empty($array)) {
            $matchingProperties = [];

            foreach ($keys as $property) {
                if ($matchedAttribute = static::getValue($array, $property)) {
                    $matchingProperties[$property] = $matchedAttribute;
                }
            }

            return $matchingProperties;
        }

        return $array;
    }
}
