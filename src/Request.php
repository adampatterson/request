<?php

namespace Request;

use Request\Actions\MakeRequest;

/**
 * Class Request
 *
 * @package Request
 * @author Adam Patterson <http://github.com/adampatterson>
 * @link  https://github.com/adampatterson/Request
 *
 * @method static \Symfony\Component\HttpFoundation\Request instance()
 * @method static string method()
 * @method static string root()
 * @method static string uri()
 * @method static string|null ip()
 * @method static string|null userAgent()
 * @method static mixed get(string $key, ?string $default = null)
 * @method static bool has(string $key)
 * @method static array all(string $method = 'GET')
 * @method static \Request\Actions\MakeRequest new(...$args)
 *
 * @mixin MakeRequest
 */
class Request
{
    /**
     * The cached MakeRequest instance.
     *
     * @var MakeRequest|null
     */
    protected static ?MakeRequest $instance = null;


    /**
     * Clear the resolved instance.
     *
     * @return void
     */
    public static function clearResolvedInstance(): void
    {
        static::$instance = null;
    }

    /**
     * Resolve the MakeRequest instance.
     *
     * @return MakeRequest
     */
    public static function resolveInstance(): MakeRequest
    {
        if (!static::$instance) {
            static::$instance = MakeRequest::new();
        }

        return static::$instance;
    }

    /**
     * Handle static calls to the MakeRequest instance.
     *
     * @param  string  $method
     * @param  array  $args
     * @return mixed
     */
    public static function __callStatic(string $method, array $args)
    {
        return static::resolveInstance()->{$method}(...$args);
    }
}
