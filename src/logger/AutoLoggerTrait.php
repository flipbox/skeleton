<?php

/**
 * Auto Logger Trait
 *
 * Attache log methods to an object.
 *
 * @package    Skeleton
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 *
 * @link       https://github.com/flipbox/skeleton
 * @since      1.0.0
 */

namespace flipbox\skeleton\logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

trait AutoLoggerTrait
{

    use LoggerTrait;

    /**
     * The logger instance.
     *
     * @var LoggerInterface
     */
    private $_logger;

    /**
     * Set a logger
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->_logger = $logger;
    }

    /**
     * Get a logger
     *
     * @return LoggerInterface|null
     */
    public function getLogger()
    {
        return $this->_logger;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     */
    public function log($level, $message, array $context = array())
    {
        if ($this->getLogger()) {
            $this->getLogger()->log($level, $message, $context);
        }
    }

}