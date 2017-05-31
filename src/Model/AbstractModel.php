<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Model;

use Flipbox\Skeleton\Error\ErrorTrait;
use Flipbox\Skeleton\Object\AbstractObject;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
abstract class AbstractModel extends AbstractObject implements ModelInterface
{
    use ErrorTrait;
}
