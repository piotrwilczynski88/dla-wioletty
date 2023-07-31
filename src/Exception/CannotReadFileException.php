<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class CannotReadFileException extends Exception
{
    public function __construct(string $fileName)
    {
        parent::__construct(
            message: sprintf('There was an error why reading %s', $fileName),
        );
    }
}
