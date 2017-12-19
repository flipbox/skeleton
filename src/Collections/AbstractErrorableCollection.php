<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Collections;

use Flipbox\Skeleton\Error\ErrorTrait;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 * @deprecated
 */
abstract class AbstractErrorableCollection extends AbstractObjectCollection implements ErrorableCollectionInterface
{
    use ErrorTrait;
}
