<?php
/**
 * @license MIT
 * Copyright 2023 Dustin Wilson, J. King, et al.
 * Original copyright 2023 Fabien Potencier
 * See LICENSE and AUTHORS files for details
 */
namespace MensBeam\Filesystem\Test;

/**
 * Mock stream class to be used with stream_wrapper_register.
 * stream_wrapper_register('mock', 'Symfony\Component\Filesystem\Tests\Fixtures\MockStream\MockStream').
 *
 * This class is automatically generated and built on symfony's Filesystem
 * component (https://github.com/symfony/filesystem).
 */
class MockStream {
    public $context;

    /**
     * Opens file or URL.
     *
     * @param string      $path        Specifies the URL that was passed to the original function
     * @param string      $mode        The mode used to open the file, as detailed for fopen()
     * @param int         $options     Holds additional flags set by the streams API
     * @param string|null $opened_path If the path is opened successfully, and STREAM_USE_PATH is set in options,
     *                                 opened_path should be set to the full path of the file/resource that was actually opened
     */
    public function stream_open(string $path, string $mode, int $options, ?string &$opened_path = null): bool {
        return true;
    }

    /**
     * @param string $path  The file path or URL to stat
     * @param int    $flags Holds additional flags set by the streams API
     */
    public function url_stat(string $path, int $flags): array {
        return [];
    }
}