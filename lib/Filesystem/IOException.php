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
 * Exception class thrown when a filesystem operation failure happens.
 *
 * @author Romain Neutron <imprec@gmail.com>
 * @author Christian Gärtner <christiangaertner.film@googlemail.com>
 * @author Fabien Potencier <fabien@symfony.com>
 */
class IOException extends \RuntimeException {
    private ?string $path;

    public function __construct(string $message, int $code = 0, \Throwable $previous = null, string $path = null) {
        $this->path = $path;

        parent::__construct($message, $code, $previous);
    }

    public function getPath(): ?string {
        return $this->path;
    }
}
