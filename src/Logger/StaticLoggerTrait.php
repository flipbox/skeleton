<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/skeleton/blob/master/LICENSE
 * @link       https://github.com/flipbox/skeleton
 */

namespace Flipbox\Skeleton\Logger;

use Psr\Log\LogLevel;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
trait StaticLoggerTrait
{
    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     */
    public static function emergency($message, array $context = [])
    {
        self::log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     */
    public static function alert($message, array $context = [])
    {
        self::log(LogLevel::ALERT, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     */
    public static function critical($message, array $context = [])
    {
        self::log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     */
    public static function error($message, array $context = [])
    {
        self::log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     */
    public static function warning($message, array $context = [])
    {
        self::log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     */
    public static function notice($message, array $context = [])
    {
        self::log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     */
    public static function info($message, array $context = [])
    {
        self::log(LogLevel::INFO, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     */
    public static function debug($message, array $context = [])
    {
        self::log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     */
    abstract public static function log($level, $message, array $context = []);
}
