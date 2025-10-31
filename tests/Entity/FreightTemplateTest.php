<?php

declare(strict_types=1);

namespace Tourze\FreightTemplateBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\FreightTemplateBundle\Entity\FreightTemplate;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;

/**
 * @internal
 */
#[CoversClass(FreightTemplate::class)]
final class FreightTemplateTest extends AbstractEntityTestCase
{
    protected function createEntity(): FreightTemplate
    {
        return new FreightTemplate();
    }

    /**
     * @return array<string, array{string, mixed}>
     */
    public static function propertiesProvider(): array
    {
        return [
            'valid1' => ['valid', true],
            'valid2' => ['valid', false],
            'name' => ['name', '测试运费模板'],
            'currency' => ['currency', 'CNY'],
            'fee' => ['fee', '10.50'],
        ];
    }

    public function testCanBeInstantiated(): void
    {
        $entity = new FreightTemplate();
        $this->assertInstanceOf(FreightTemplate::class, $entity);
    }
}
