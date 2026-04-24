<?php

namespace Request;

use Symfony\Component\HttpFoundation\Request;

class MakeRequest
{

    /** @var Request */
    protected $request;

    /** @var string|null */
    protected $pathInfo;

    /** @var string|null */
    protected $requestUri;

    /** @var string|null */
    protected $baseUrl;

    /** @var string|null */
    protected $basePath;

    /** @var string|null */
    protected $method;

    /**
     * Create a new MakeRequest instance.
     *
     * @param  mixed  ...$args
     * @return static
     */
    public static function new(...$args)
    {
        return new self(...$args);
    }

    /**
     * MakeRequest constructor.
     */
    public function __construct()
    {
        $this->request = Request::createFromGlobals();

        $this->pathInfo = null;
        $this->requestUri = null;
        $this->baseUrl = null;
        $this->basePath = null;
        $this->method = null;
    }

    /**
     * Get the Symfony request instance.
     *
     * @return Request
     */
    public function instance(): Request
    {
        return $this->request;
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public function method(): string
    {
        return $this->request->getMethod();
    }

    /**
     * Get the root URL.
     *
     * @return string
     */
    public function root(): string
    {
        return rtrim($this->request->getSchemeAndHttpHost().$this->request->getBaseUrl(), '/');
    }

    /**
     * Get the full URI.
     *
     * @return string
     */
    public function uri(): string
    {
        return $this->request->getUri();
    }

    /**
     * Get the client IP address.
     *
     * @return string|null
     */
    public function ip(): ?string
    {
        return $this->request->getClientIp();
    }

    /**
     * Get the client user agent.
     *
     * @return string|null
     */
    public function userAgent(): ?string
    {
        return $this->request->headers->get('User-Agent');
    }

    /**
     * Retrieve a value from the request.
     *
     * If access to the full Symfony component is needed, then use
     * $this->request->get
     *
     * @param  string  $key
     * @param  mixed  $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null): mixed
    {
        if ($this->request->query->has($key)) {
            return $this->request->query->get($key);
        }

        return $this->request->request->get($key, $default);
    }

    /**
     * Determine if a value exists in the query string.
     *
     * @param  string  $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->request->query->has($key);
    }

    /**
     * Get all input from the request.
     *
     * @param  string  $method
     * @return array
     */
    public function all($method = 'GET'): array
    {
        return match ($method) {
            'get', 'GET'       => $this->request->query->all(),
            'post', 'POST'     => $this->request->request->all(),
            'cookie', 'COOKIE' => $this->request->cookies->all(),
        };
    }
}
