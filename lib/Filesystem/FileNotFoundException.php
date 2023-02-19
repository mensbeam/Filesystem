<?php
/**
 * @license MIT
 * Copyright 2023 Dustin Wilson, J. King, et al.
 * Original copyright 2023 Fabien Potencier
 * See LICENSE and AUTHORS files for details
 */

declare(strict_types=1);
namespace MensBeam\Filesystem;


/**
 * Exception class thrown when a file couldn't be found.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Christian Gärtner <christiangaertner.film@googlemail.com>
 */
class FileNotFoundException extends IOException {
    public function __construct(string $message = null, int $code = 0, \Throwable $previous = null, string $path = null) {
        if (null === $message) {
            if (null === $path) {
                $message = 'File could not be found.';
            } else {
                $message = sprintf('File "%s" could not be found.', $path);
            }
        }

        parent::__construct($message, $code, $previous, $path);
    }
}