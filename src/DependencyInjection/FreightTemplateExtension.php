<?php

namespace Tourze\FreightTemplateBundle\DependencyInjection;

use Tourze\SymfonyDependencyServiceLoader\AutoExtension;

class FreightTemplateExtension extends AutoExtension
{
    protected function getConfigDir(): string
    {
        return __DIR__ . '/../Resources/config';
    }
}
