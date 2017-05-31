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
trait ErrorTrait
{
    /**
     * @var array The errors (key => value[])
     */
    protected $_errors;

    /**
     * Identify whether there are any errors
     *
     * @param null $attribute
     * @return bool
     */
    public function hasErrors($attribute = null): bool
    {
        $errors = $this->getErrors();
        return $attribute === null ? !empty($errors) : isset($errors[$attribute]);
    }

    /**
     * Returns the errors for all attribute or a single attribute.
     *
     * @param null $attribute
     * @return array
     */
    public function getErrors($attribute = null): array
    {
        if ($attribute === null) {
            return $this->_errors === null ? [] : $this->_errors;
        } else {
            return isset($this->_errors[$attribute]) ? $this->_errors[$attribute] : [];
        }
    }

    /**
     * Returns the first error of every attribute in the model.
     *
     * @return array
     */
    public function getFirstErrors(): array
    {
        $errors = $this->getErrors();
        if (empty($errors)) {
            return [];
        } else {
            $errors = [];
            foreach ($errors as $name => $es) {
                if (!empty($es)) {
                    $errors[$name] = reset($es);
                }
            }

            return $errors;
        }
    }

    /**
     * Returns the first error of the specified attribute.
     *
     * @param $attribute
     * @return string|null
     */
    public function getFirstError($attribute)
    {
        $errors = $this->getErrors();
        return isset($errors[$attribute]) ? reset($errors[$attribute]) : null;
    }

    /**
     * Adds a new error to the specified attribute.
     *
     * @param $attribute
     * @param string $error
     */
    public function addError($attribute, $error = '')
    {
        $this->_errors[$attribute][] = $error;
    }

    /**
     * Adds a list of errors.
     *
     * @param array $items
     */
    public function addErrors(array $items)
    {
        foreach ($items as $attribute => $errors) {
            if (is_array($errors)) {
                foreach ($errors as $error) {
                    $this->addError($attribute, $error);
                }
            } else {
                $this->addError($attribute, $errors);
            }
        }
    }

    /**
     * Removes errors for all attributes or a single attribute.
     *
     * @param null $attribute
     */
    public function clearErrors($attribute = null)
    {
        if ($attribute === null) {
            $this->_errors = [];
        } else {
            unset($this->_errors[$attribute]);
        }
    }
}
