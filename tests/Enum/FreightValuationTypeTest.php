<?php

declare(strict_types=1);

namespace Tourze\FreightTemplateBundle\Tests\Enum;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\FreightTemplateBundle\Enum\FreightValuationType;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;

/**
 * @internal
 */
#[CoversClass(FreightValuationType::class)]
final class FreightValuationTypeTest extends AbstractEnumTestCase
{
    public function testGenOptions(): void
    {
        $options = FreightValuationType::genOptions();
        $this->assertCount(count(FreightValuationType::cases()), $options);

        foreach ($options as $item) {
            $this->assertArrayHasKey('value', $item);
            $this->assertArrayHasKey('label', $item);
        }
    }

    public function testToArray(): void
    {
        foreach (FreightValuationType::cases() as $case) {
            $result = $case->toArray();

            $this->assertArrayHasKey('value', $result);
            $this->assertArrayHasKey('label', $result);
            $this->assertSame($case->value, $result['value']);
            $this->assertSame($case->getLabel(), $result['label']);
        }
    }
}
