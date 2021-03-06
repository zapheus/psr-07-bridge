<?php

namespace Zapheus\Bridge\Psr\Zapheus;

use Zapheus\Bridge\Psr\ServerRequest;
use Zapheus\Bridge\Psr\Stream as PsrStream;
use Zapheus\Http\Message\File;
use Zapheus\Http\Message\RequestFactory;
use Zapheus\Http\Message\Uri;

/**
 * Request Test
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Http\Message\RequestFactory
     */
    protected $factory;

    /**
     * @var array
     */
    protected $files = array('file' => array());

    /**
     * @var array
     */
    protected $server = array();

    /**
     * Sets up the request instance.
     *
     * @return void
     */
    public function setUp()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['SERVER_NAME'] = 'roug.in';
        $_SERVER['SERVER_PORT'] = 8000;

        $file = __DIR__ . '/../Fixture/Views/HelloWorld.php';

        $_FILES['file']['error'] = array(0);
        $_FILES['file']['name'] = array(basename($file));
        $_FILES['file']['size'] = array(filesize($file));
        $_FILES['file']['tmp_name'] = array($file);
        $_FILES['file']['type'] = array(mime_content_type($file));

        $request = new ServerRequest($_SERVER, array(), array(), $_FILES);

        $this->server = $request->getServerParams();

        $request = new Request($request);

        $this->factory = new RequestFactory($request);
    }

    /**
     * Tests RequestInterface::attributes.
     *
     * @return void
     */
    public function testAttributesMethod()
    {
        $expected = array('name' => 'Rougin Royce');

        $factory = $this->factory->attributes($expected);

        $result = $factory->make()->attributes();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::cookies.
     *
     * @return void
     */
    public function testCookiesMethod()
    {
        $expected = array('name' => 'Rougin', 'address' => 'Tomorrowland');

        $factory = $this->factory->cookies($expected);

        $result = $factory->make()->cookies();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::data.
     *
     * @return void
     */
    public function testDataMethod()
    {
        $expected = array('name' => 'Rougin Royce', 'age' => 20);

        $factory = $this->factory->data($expected);

        $result = $factory->make()->data();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::files.
     *
     * @return void
     */
    public function testFilesMethod()
    {
        $file = __DIR__ . '/../Fixture/Views/HelloWorld.php';

        $file = new File($file, basename($file));

        $expected = array($file);

        $factory = $this->factory->files($expected);

        $result = $factory->make()->files();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::method.
     *
     * @return void
     */
    public function testMethodMethod()
    {
        $expected = 'POST';

        $factory = $this->factory->method($expected);

        $result = $factory->make()->method();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::queries.
     *
     * @return void
     */
    public function testQueriesMethod()
    {
        $expected = array('name' => 'Rougin Royce', 'age' => 20);

        $factory = $this->factory->queries($expected);

        $result = $factory->make()->queries();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::server.
     *
     * @return void
     */
    public function testServerMethod()
    {
        $result = $this->factory->make()->server();

        $expected = (array) $this->server;

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::target.
     *
     * @return void
     */
    public function testTargetMethod()
    {
        $expected = 'origin-form';

        $factory = $this->factory->target($expected);

        $result = $factory->make()->target();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::uri.
     *
     * @return void
     */
    public function testUriMethod()
    {
        $expected = new Uri('https://roug.in');

        $factory = $this->factory->uri($expected);

        $result = $factory->make()->uri();

        $this->assertEquals($expected, $result);
    }
}
