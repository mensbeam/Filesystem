<?php
/**
 * @license MIT
 * Copyright 2023 Dustin Wilson, J. King, et al.
 * Original copyright 2023 Fabien Potencier
 * See LICENSE and AUTHORS files for details
 */
namespace MensBeam\Filesystem\Test;

use PHPUnit\Framework\TestCase;


use MensBeam\Filesystem\{
    FileNotFoundException,
    IOException
};


use PHPUnit\Framework\Attributes\CoversClass;


/**
 * Test class for Filesystem.
 *
 * This class is automatically generated and built on symfony's Filesystem
 * component (https://github.com/symfony/filesystem).
 */
#[CoversClass(IOException::class)]
#[CoversClass(FileNotFoundException::class)]
class TestExceptions extends TestCase {
    public function testCustomMessage() {
        $e = new FileNotFoundException('bar', 0, null, '/foo');
        $this->assertEquals('bar', $e->getMessage(), 'A custom message should be possible still.');
    }

    public function testGeneratedMessage() {
        $e = new FileNotFoundException(null, 0, null, '/foo');
        $this->assertEquals('/foo', $e->getPath());
        $this->assertEquals('File "/foo" could not be found.', $e->getMessage(), 'A message should be generated.');
    }

    public function testGeneratedMessageWithoutPath() {
        $e = new FileNotFoundException();
        $this->assertEquals('File could not be found.', $e->getMessage(), 'A message should be generated.');
    }

    public function testGetPath() {
        $e = new IOException('', 0, null, '/foo');
        $this->assertEquals('/foo', $e->getPath(), 'The pass should be returned.');
    }
}