<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Error;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
interface ErrorInterface
{
    /**
     * Identify whether there are any errors
     *
     * @param null $attribute
     * @return bool
     */
    public function hasErrors($attribute = null);

    /**
     * Returns the errors for all attribute or a single attribute.
     *
     * @param null $attribute
     * @return array
     */
    public function getErrors($attribute = null);

    /**
     * Returns the first error of every attribute in the model.
     *
     * @return array
     */
    public function getFirstErrors();

    /**
     * Returns the first error of the specified attribute.
     *
     * @param $attribute
     * @return string|null
     */
    public function getFirstError($attribute);

    /**
     * Adds a new error to the specified attribute.
     *
     * @param $attribute
     * @param string $error
     */
    public function addError($attribute, $error = '');

    /**
     * Adds a list of errors.
     *
     * @param array $items
     */
    public function addErrors(array $items);

    /**
     * Removes errors for all attributes or a single attribute.
     *
     * @param null $attribute
     */
    public function clearErrors($attribute = null);
}
