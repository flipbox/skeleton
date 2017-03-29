<?php

/**
 * Abstract Model
 *
 * @package    Skeleton
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 *
 * @link       https://github.com/flipbox/skeleton
 * @since      1.0.0
 */

namespace flipbox\skeleton\model;

use flipbox\skeleton\error\ErrorTrait;
use flipbox\skeleton\object\AbstractObject;

abstract class AbstractModel extends AbstractObject implements ModelInterface
{

    use ErrorTrait;

}
