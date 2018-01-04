<?php

namespace Zapheus\Bridge\Psr;

use Zend\Diactoros\Stream as ZendStream;

/**
 * Stream Test
 *
 * @package Slytherin
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class StreamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Http\Message\StreamInterface
     */
    protected $stream;

    /**
     * @var \Psr\Http\Message\StreamInterface
     */
    protected $psr;

    /**
     * Sets up the stream instance.
     *
     * @return void
     */
    public function setUp()
    {
        $file = __DIR__ . '/../../../Fixture/Views/LoremIpsum.php';

        $resource = fopen($file, 'r');

        $this->psr = new ZendStream($resource);

        $this->stream = new Stream($this->psr);
    }

    /**
     * Tests StreamInterface::__toString.
     *
     * @return void
     */
    public function testToStringMagicMethod()
    {
        $expected = 'Lorem ipsum dolor sit amet';

        $result = (string) $this->stream;

        $this->stream->close();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::eof.
     *
     * @return void
     */
    public function testEofMethod()
    {
        $file = __DIR__ . '/../../../Fixture/Views/HelloWorld.php';

        $resource = fopen($file, 'w');

        $stream = new Stream(new ZendStream($resource));

        $expected = false;

        $result = $stream->eof();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::getContents with \RuntimeException.
     *
     * @return void
     */
    public function testGetContentsMethodWithRuntimeException()
    {
        $this->setExpectedException('RuntimeException');

        $file = __DIR__ . '/../../../Fixture/Views/HelloWorld.php';

        $resource = fopen($file, 'w');

        $stream = new Stream(new ZendStream($resource));

        $stream->getContents();
    }

    /**
     * Tests StreamInterface::getMetadata.
     *
     * @return void
     */
    public function testGetMetadataMethod()
    {
        $expected = array('eof' => false);

        $expected['timed_out'] = null;
        $expected['blocked'] = 1;
        $expected['wrapper_type'] = 'plainfile';
        $expected['stream_type'] = 'STDIO';
        $expected['mode'] = 'r';
        $expected['unread_bytes'] = 0;
        $expected['seekable'] = 1;
        $expected['uri'] = __DIR__ . '/../../../Fixture/Views/LoremIpsum.php';

        $result = $this->stream->getMetadata();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::getSize.
     *
     * @return void
     */
    public function testGetSizeMethod()
    {
        $expected = 26;

        $result = $this->stream->getSize();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::isReadable.
     *
     * @return void
     */
    public function testIsReadableMethod()
    {
        $expected = $this->psr->isReadable();

        $result = $this->stream->isReadable();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::isSeekable.
     *
     * @return void
     */
    public function testIsSeekableMethod()
    {
        $expected = $this->psr->isSeekable();

        $result = $this->stream->isSeekable();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::isWritable.
     *
     * @return void
     */
    public function testIsWritableMethod()
    {
        $expected = $this->psr->isWritable();

        $result = $this->stream->isWritable();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::read.
     *
     * @return void
     */
    public function testReadMethod()
    {
        $expected = 'Lorem ipsum dolor sit amet';

        $result = $this->stream->read(26);

        $this->stream->close();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::read with \RuntimeException.
     *
     * @return void
     */
    public function testReadMethodWithRuntimeException()
    {
        $this->setExpectedException('RuntimeException');

        $file = __DIR__ . '/../../../Fixture/Views/HelloWorld.php';

        $resource = fopen($file, 'w');

        $stream = new Stream(new ZendStream($resource));

        $stream->read(4);
    }

    /**
     * Tests StreamInterface::rewind.
     *
     * @return void
     */
    public function testRewindMethod()
    {
        // TODO: Must be connected to PsrStream::rewind
        $expected = 'Lorem ipsum dolor sit amet';

        $this->stream->rewind();

        $result = $this->stream->getContents();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::seek and StreamInterface::tell.
     *
     * @return void
     */
    public function testSeekMethodAndTellMethod()
    {
        $expected = 2;

        $file = __DIR__ . '/../../../Fixture/Views/HelloWorld.php';

        $resource = fopen($file, 'w');

        $stream = new Stream(new ZendStream($resource));

        $stream->seek($expected);

        $result = $stream->tell();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::seek and StreamInterface::detach.
     *
     * @return void
     */
    public function testSeekMethodAndDetachMethod()
    {
        $this->setExpectedException('RuntimeException');

        $file = __DIR__ . '/../../../Fixture/Views/HelloWorld.php';

        $resource = fopen($file, 'w');

        $stream = new Stream(new ZendStream($resource));

        $stream->detach();

        $stream->seek(2);
    }

    /**
     * Tests StreamInterface::tell and StreamInterface::detach.
     *
     * @return void
     */
    public function testTellMethodAndDetachMethod()
    {
        $this->setExpectedException('RuntimeException');

        $file = __DIR__ . '/../../../Fixture/Views/HelloWorld.php';

        $resource = fopen($file, 'w');

        $stream = new Stream(new ZendStream($resource));

        $stream->detach();

        $stream->tell();
    }

    /**
     * Tests StreamInterface::write with \RuntimeException.
     *
     * @return void
     */
    public function testWriteMethodWithRuntimeException()
    {
        $this->setExpectedException('RuntimeException');

        $file = __DIR__ . '/../../../Fixture/Views/LoremIpsum.php';

        $resource = fopen($file, 'r');

        $stream = new Stream(new ZendStream($resource));

        $stream->write('Hello world');
    }
}
