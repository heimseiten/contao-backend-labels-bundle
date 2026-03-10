<?php

declare(strict_types=1);

namespace Solidwork\ContaoBackendLabelsBundle;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class ContaoBackendLabelsBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}