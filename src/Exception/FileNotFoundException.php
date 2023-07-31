<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class FileNotFoundException extends Exception
{
    public function __construct(string $fileName)
    {
        parent::__construct(
            message: sprintf('File %s not found', $fileName),
        );
    }
}
