<?php

declare(strict_types=1);

namespace Tourze\FreightTemplateBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\FreightTemplateBundle\DependencyInjection\FreightTemplateExtension;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;

/**
 * @internal
 */
#[CoversClass(FreightTemplateExtension::class)]
final class FreightTemplateExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
}
