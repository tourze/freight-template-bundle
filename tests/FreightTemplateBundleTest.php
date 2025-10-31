<?php

declare(strict_types=1);

namespace Tourze\FreightTemplateBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\FreightTemplateBundle\DependencyInjection\FreightTemplateExtension;
use Tourze\FreightTemplateBundle\FreightTemplateBundle;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;

/**
 * @internal
 */
#[CoversClass(FreightTemplateBundle::class)]
#[RunTestsInSeparateProcesses]
final class FreightTemplateBundleTest extends AbstractBundleTestCase
{
}
