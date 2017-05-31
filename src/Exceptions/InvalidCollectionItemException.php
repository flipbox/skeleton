<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Exceptions;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
class InvalidCollectionItemException extends \Exception
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Invalid Collection Item Exception';
    }
}
