<?php

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
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

        Request::clearResolvedInstance();
    }

    #[Test]
    public function it_is_a_singleton(): void
    {
        $instance1 = Request::resolveInstance();
        $instance2 = Request::resolveInstance();

        $this->assertSame($instance1, $instance2);
    }

    #[Test]
    public function it_returns_the_instance(): void
    {
        $this->assertInstanceOf(Symfony\Component\HttpFoundation\Request::class, Request::instance());
    }

    #[Test]
    public function it_can_be_called_statically(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->assertEquals('POST', Request::method());
    }

    #[Test]
    public function it_returns_the_request_method(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';

        $this->assertEquals('PUT', Request::method());
    }

    #[Test]
    public function it_returns_the_root(): void
    {
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['PHP_SELF'] = '/index.php';

        $this->assertEquals('http://example.com', Request::root());
    }

    #[Test]
    public function it_returns_the_uri(): void
    {
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['REQUEST_URI'] = '/test/path?query=1';
        $_SERVER['QUERY_STRING'] = 'query=1';

        $this->assertEquals('http://example.com/test/path?query=1', Request::uri());
    }

    #[Test]
    public function it_returns_client_ip(): void
    {
        $_SERVER['REMOTE_ADDR'] = '192.168.1.100';
        $this->assertEquals('192.168.1.100', Request::ip());
    }

    #[Test]
    public function it_returns_user_agent(): void
    {
        $_SERVER['HTTP_USER_AGENT'] = 'PHPUnit Test Agent';

        $this->assertEquals('PHPUnit Test Agent', Request::userAgent());
    }

    #[Test]
    public function it_can_get_a_value(): void
    {
        $_GET['foo'] = 'bar';
        $_POST['test'] = 'value'; // Symfony request get() checks query, request, etc.

        $this->assertEquals('bar', Request::get('foo'));
        $this->assertEquals('value', Request::get('test'));
        $this->assertEquals('default', Request::get('missing', 'default'));
    }

    #[Test]
    public function it_can_get_all_query_values(): void
    {
        $_GET = [
            'foo' => 'bar',
            'baz' => 'qux',
        ];

        // MakeRequest->all() specifically calls $this->request->query->all() which maps to $_GET
        $this->assertEquals($_GET, Request::all());
    }

    #[Test]
    public function it_can_get_all_post_values(): void
    {
        $_POST = [
            'foo' => 'bar',
            'baz' => 'qux',
        ];

        $this->assertEquals($_POST, Request::all('POST'));
        $this->assertEquals($_POST, Request::all('post'));
    }

    #[Test]
    public function it_can_get_all_cookie_values(): void
    {
        $_COOKIE = [
            'session_id' => '12345',
        ];

        $this->assertEquals($_COOKIE, Request::all('COOKIE'));
        $this->assertEquals($_COOKIE, Request::all('cookie'));
    }

    #[Test]
    public function it_can_check_if_a_key_exists(): void
    {
        $_GET['foo'] = 'bar';

        $this->assertTrue(Request::has('foo'));
        $this->assertFalse(Request::has('bar'));
    }

    #[Test]
    public function it_proxies_method_calls_to_the_underlying_request(): void
    {
        $_SERVER['REQUEST_URI'] = '/test-path';

        // getPathInfo() is a method on Symfony's Request, but not on MakeRequest
        $this->assertEquals('/test-path', Request::getPathInfo());
        $this->assertEquals('/test-path', Request::getPathInfo());
    }
}
