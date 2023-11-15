<?php
/**
 * @license MIT
 * Copyright 2022 Dustin Wilson, et al.
 * See LICENSE and AUTHORS files for details
 */

declare(strict_types=1);
namespace MensBeam\Filesystem\Test;

use PHPUnit\Framework\TestCase;
use MensBeam\Filesystem\FileNotFoundException;
use MensBeam\Filesystem\IOException;

/**
 * @covers \MensBeam\Filesystem\FileNotFoundException
 * @covers \MensBeam\Filesystem\InvalidArgumentException
 * @covers \MensBeam\Filesystem\IOException
 */
class TestExceptions extends TestCase {
    public function testGetPath() {
        $e = new IOException('', 0, null, '/foo');
        $this->assertEquals('/foo', $e->getPath(), 'The pass should be returned.');
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

    public function testCustomMessage() {
        $e = new FileNotFoundException('bar', 0, null, '/foo');
        $this->assertEquals('bar', $e->getMessage(), 'A custom message should be possible still.');
    }
}
