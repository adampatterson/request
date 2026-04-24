<?php

namespace Request;

/**
 * Class Request
 *
 * @package Request
 * @author Adam Patterson <http://github.com/adampatterson>
 * @link  https://github.com/adampatterson/Request
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
    public static function __callStatic($method, $args)
    {
        return MakeRequest::new()->{$method}(...$args);
    }
}
