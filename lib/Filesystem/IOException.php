<?php
/**
 * @license MIT
 * Copyright 2023 Dustin Wilson, J. King, et al.
 * Original copyright 2023 Fabien Potencier
 * See LICENSE and AUTHORS files for details
 */
namespace MensBeam\Filesystem;

/**
 * Exception class thrown when a filesystem operation failure happens.
 *
 * @author Romain Neutron <imprec@gmail.com>
 * @author Christian Gärtner <christiangaertner.film@googlemail.com>
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * This class is automatically generated and built on symfony's Filesystem
 * component (https://github.com/symfony/filesystem).
 */
class IOException extends \RuntimeException {
    public function __construct(string $message, int $code = 0, ?\Throwable $previous = null, private ?string $path = null) {
        parent::__construct($message, $code, $previous);
    }




    public function getPath(): ?string {
        return $this->path;
    }
}