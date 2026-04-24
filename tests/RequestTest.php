<?php

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Request\Actions\MakeRequest;
use Request\Request;

class RequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Clear global variables before each test to ensure clean state
        $_SERVER = [];
        $_GET = [];
        $_POST = [];
        $_COOKIE = [];
        $_FILES = [];
    }

    #[Test]
    public function it_returns_the_instance()
    {
        $request = Request::new();
        $this->assertInstanceOf(Symfony\Component\HttpFoundation\Request::class, $request->instance());
    }

    #[Test]
    public function it_can_be_called_statically()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->assertEquals('POST', Request::method());
    }

    #[Test]
    public function it_returns_the_request_method()
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';

        $request = MakeRequest::new();
        $this->assertEquals('PUT', $request->method());
    }

    #[Test]
    public function it_returns_the_root()
    {
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['PHP_SELF'] = '/index.php';

        $this->assertEquals('http://example.com', Request::root());
    }

    #[Test]
    public function it_returns_the_uri()
    {
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['REQUEST_URI'] = '/test/path?query=1';
        $_SERVER['QUERY_STRING'] = 'query=1';

        $this->assertEquals('http://example.com/test/path?query=1', Request::uri());
    }

    #[Test]
    public function it_returns_client_ip()
    {
        $_SERVER['REMOTE_ADDR'] = '192.168.1.100';

        $request = MakeRequest::new();
        $this->assertEquals('192.168.1.100', $request->ip());
    }

    #[Test]
    public function it_returns_user_agent()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'PHPUnit Test Agent';

        $request = MakeRequest::new();
        $this->assertEquals('PHPUnit Test Agent', $request->userAgent());
    }

    #[Test]
    public function it_can_get_a_value()
    {
        $_GET['foo'] = 'bar';
        $_POST['test'] = 'value'; // Symfony request get() checks query, request, etc.

        $request = MakeRequest::new();

        $this->assertEquals('bar', $request->get('foo'));
        $this->assertEquals('value', $request->get('test'));
        $this->assertEquals('default', $request->get('missing', 'default'));
    }

    #[Test]
    public function it_can_get_all_query_values()
    {
        $_GET = [
            'foo' => 'bar',
            'baz' => 'qux',
        ];

        // MakeRequest->all() specifically calls $this->request->query->all() which maps to $_GET
        $request = MakeRequest::new();

        $this->assertEquals($_GET, $request->all());
    }

    #[Test]
    public function it_proxies_method_calls_to_the_underlying_request()
    {
        $_SERVER['REQUEST_URI'] = '/test-path';

        $request = MakeRequest::new();

        // getPathInfo() is a method on Symfony's Request, but not on MakeRequest
        $this->assertEquals('/test-path', $request->getPathInfo());
        $this->assertEquals('/test-path', Request::getPathInfo());
    }
}
