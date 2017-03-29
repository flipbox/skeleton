<?php

/**
 * Errorable Collection
 *
 * @package    Skeleton
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 *
 * @link       https://github.com/flipbox/skeleton
 * @since      1.0.0
 */

namespace flipbox\skeleton\collections;

use flipbox\skeleton\error\ErrorTrait;

abstract class AbstractErrorableCollection extends AbstractObjectCollection implements ErrorableCollectionInterface
{

    use ErrorTrait;

}
