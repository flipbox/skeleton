<?php

/**
 * Invalid Call Exception
 *
 * @package    Skeleton
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 *
 * @link       https://github.com/flipbox/skeleton
 * @since      1.0.0
 */

namespace flipbox\skeleton\exceptions;

class InvalidCallException extends \Exception
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Invalid Call Exception';
    }
}
