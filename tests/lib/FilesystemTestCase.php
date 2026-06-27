<?php
/**
 * @license MIT
 * Copyright 2023 Dustin Wilson, J. King, et al.
 * Original copyright 2023 Fabien Potencier
 * See LICENSE and AUTHORS files for details
 */
namespace MensBeam\Filesystem\Test;

use MensBeam\{
    Filesystem as Fs,
    Filesystem
};


use PHPUnit\Framework\TestCase;


use PHPUnit\Framework\Attributes\CoversClass;


class FilesystemTestCase extends TestCase {
    protected static ?bool $linkOnWindows = null;
    protected array $longPathNamesWindows = [];
    protected static ?bool $symlinkOnWindows = null;
    protected int $umask;
    protected string $workspace;

    public static function setUpBeforeClass(): void {
        if ('\\' === \DIRECTORY_SEPARATOR) {
            self::$linkOnWindows = true;
            $originFile = tempnam(sys_get_temp_dir(), 'li');
            $targetFile = tempnam(sys_get_temp_dir(), 'li');
            if (true !== @link($originFile, $targetFile)) {
                $report = error_get_last();
                if (\is_array($report) && str_contains($report['message'], 'error code(1314)')) {
                    self::$linkOnWindows = false;
                }
            } else {
                @unlink($targetFile);
            }
            self::$symlinkOnWindows = true;
            $originDir = tempnam(sys_get_temp_dir(), 'sl');
            $targetDir = tempnam(sys_get_temp_dir(), 'sl');
            if (true !== @symlink($originDir, $targetDir)) {
                $report = error_get_last();
                if (\is_array($report) && str_contains($report['message'], 'error code(1314)')) {
                    self::$symlinkOnWindows = false;
                }
            } else {
                @unlink($targetDir);
            }
        }
    }


    /**
     * @param int    $expectedFilePerms Expected file permissions as three digits (i.e. 755)
     * @param string $filePath
     */
    protected function assertFilePermissions($expectedFilePerms, $filePath) {
        $actualFilePerms = (int) substr(\sprintf('%o', fileperms($filePath)), -3);
        $this->assertEquals($expectedFilePerms, $actualFilePerms, \sprintf('File permissions for %s must be %s. Actual %s', $filePath, $expectedFilePerms, $actualFilePerms));
    }

    protected function getFileGroup($filepath) {
        $this->markAsSkippedIfPosixIsMissing();
        if ($data = posix_getgrgid($this->getFileGroupId($filepath))) {
            return $data['name'];
        }
        $this->markTestSkipped('Unable to retrieve file group name');
    }

    protected function getFileGroupId($filepath) {
        $this->markAsSkippedIfPosixIsMissing();
        $infos = stat($filepath);
        return $infos['gid'];
    }

    protected function getFileOwner($filepath) {
        $this->markAsSkippedIfPosixIsMissing();
        return ($data = posix_getpwuid($this->getFileOwnerId($filepath))) ? $data['name'] : null;
    }

    protected function getFileOwnerId($filepath) {
        $this->markAsSkippedIfPosixIsMissing();
        $infos = stat($filepath);
        return $infos['uid'];
    }

    protected function markAsSkippedIfChmodIsMissing() {
        if ('\\' === \DIRECTORY_SEPARATOR) {
            $this->markTestSkipped('chmod is not supported on Windows');
        }
    }

    protected function markAsSkippedIfLinkIsMissing() {
        if (!\function_exists('link')) {
            $this->markTestSkipped('link is not supported');
        }
        if ('\\' === \DIRECTORY_SEPARATOR && false === self::$linkOnWindows) {
            $this->markTestSkipped('link requires "Create hard links" privilege on windows');
        }
    }

    protected function markAsSkippedIfPosixIsMissing() {
        if (!\function_exists('posix_isatty')) {
            $this->markTestSkipped('Function posix_isatty is required.');
        }
    }

    protected function markAsSkippedIfSymlinkIsMissing($relative = false) {
        if ('\\' === \DIRECTORY_SEPARATOR && false === self::$symlinkOnWindows) {
            $this->markTestSkipped('symlink requires "Create symbolic links" privilege on Windows');
        }
        // https://bugs.php.net/69473
        if ($relative && '\\' === \DIRECTORY_SEPARATOR && \PHP_ZTS) {
            $this->markTestSkipped('symlink does not support relative paths on thread safe Windows PHP versions');
        }
    }

    protected function setUp(): void {
        $this->umask = umask(0);
        $this->workspace = sys_get_temp_dir() . '/' . microtime(true) . '.' . mt_rand();
        mkdir($this->workspace, 0777, true);
        $this->workspace = realpath($this->workspace);
    }

    protected function tearDown(): void {
        if ($this->longPathNamesWindows) {
            foreach ($this->longPathNamesWindows as $path) {
                exec('DEL ' . $path);
            }
            $this->longPathNamesWindows = [];
        }
        Fs::remove($this->workspace);
        umask($this->umask);
    }
}