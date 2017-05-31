<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Tests\Helpers;

use Flipbox\Skeleton\Exceptions\InvalidCallException;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
class InvalidCallExceptionTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function createResolverTest()
    {
        $exception = new InvalidCallException();;
        $this->assertEquals('Invalid Call Exception', $exception->getName());
    }
}