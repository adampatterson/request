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
 * @mixin MakeRequest
 */
class Request
{

    /**
     * Handle static calls to the MakeRequest instance.
     *
     * @param  string  $method
     * @param  array  $args
     * @return mixed
     */
    public static function __callStatic(string $method, array $args)
    {
        return MakeRequest::new()->{$method}(...$args);
    }
}
