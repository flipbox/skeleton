<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Helpers;

use JsonSerializable;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
class JsonHelper
{
    /**
     * Encodes an arbitrary variable into JSON format
     *
     * @param mixed $var any number, boolean, string, array, or object to be encoded.
     * If var is a string, it will be converted to UTF-8 format first before being encoded.
     * @return string JSON string representation of input var
     */
    public static function encode($var): string
    {
        switch (gettype($var)) {
            case 'boolean':
                return $var ? 'true' : 'false';

            case 'NULL':
                return 'null';

            case 'integer':
                return (int)$var;

            case 'double':
            case 'float':
                return str_replace(',', '.', (float)$var); // locale-independent representation

            case 'string':
                return json_encode($var);

            case 'array':
                /*
                 * As per JSON spec if any array key is not an integer
                 * we must treat the the whole array as an object. We
                 * also try to catch a sparsely populated associative
                 * array with numeric keys here because some JS engines
                 * will create an array with empty indexes up to
                 * max_index which can cause memory issues and because
                 * the keys, which may be relevant, will be remapped
                 * otherwise.
                 *
                 * As per the ECMA and JSON specification an object may
                 * have any string as a property. Unfortunately due to
                 * a hole in the ECMA specification if the key is a
                 * ECMA reserved word or starts with a digit the
                 * parameter is only accessible using ECMAScript's
                 * bracket notation.
                 */

                // treat as a JSON object
                if (is_array($var) &&
                    count($var) &&
                    (array_keys($var) !== range(0, sizeof($var) - 1))
                ) {
                    return '{' .
                        join(
                            ',',
                            array_map(
                                [
                                    JsonHelper::class,
                                    'nameValue'
                                ],
                                array_keys($var),
                                array_values($var)
                            )
                        ) . '}';
                }

                // treat it like a regular array
                return '[' . join(',', array_map(array(JsonHelper::class, 'encode'), $var)) . ']';

            case 'object':
                // Check for the JsonSerializable interface available in PHP5.4
                // Note that instanceof returns false in case it doesn't know the interface.
                if (interface_exists('JsonSerializable', false) && $var instanceof JsonSerializable) {
                    // We use the function defined in the interface instead of json_encode.
                    // This way even for PHP < 5.4 one could define the interface and use it.
                    return self::encode($var->jsonSerialize());
                } elseif ($var instanceof \Traversable) {
                    $vars = [];
                    foreach ($var as $k => $v) {
                        $vars[$k] = $v;
                    }
                } else {
                    $vars = get_object_vars($var);
                }
                return '{' .
                    join(
                        ',',
                        array_map(
                            [
                                JsonHelper::class,
                                'nameValue'
                            ],
                            array_keys($vars),
                            array_values($vars)
                        )
                    ) . '}';

            default:
                return '';
        }
    }

    /**
     * array-walking function for use in generating JSON-formatted name-value pairs
     *
     * @param string $name name of key to use
     * @param mixed $value reference to an array element to be encoded
     *
     * @return   string  JSON-formatted name-value pair, like '"name":value'
     * @access   private
     */
    protected static function nameValue($name, $value)
    {
        return self::encode(strval($name)) . ':' . self::encode($value);
    }
}
