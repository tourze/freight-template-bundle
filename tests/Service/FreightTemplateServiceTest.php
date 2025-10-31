<?php

declare(strict_types=1);

namespace Tourze\FreightTemplateBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\FreightTemplateBundle\Service\FreightTemplateService;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;

/**
 * @internal
 */
#[CoversClass(FreightTemplateService::class)]
#[RunTestsInSeparateProcesses]
final class FreightTemplateServiceTest extends AbstractIntegrationTestCase
{
    protected function onSetUp(): void
    {
        // 设置测试环境
    }

    public function testCanBeInstantiated(): void
    {
        $service = self::getService(FreightTemplateService::class);
        $this->assertInstanceOf(FreightTemplateService::class, $service);
    }

    public function testFindAllValidTemplates(): void
    {
        $service = self::getService(FreightTemplateService::class);
        $result = $service->findAllValidTemplates();

        $this->assertIsArray($result);
        // 验证结果只包含对象类型
        foreach ($result as $item) {
            $this->assertIsObject($item);
        }
    }

    public function testFindValidTemplateById(): void
    {
        $service = self::getService(FreightTemplateService::class);
        $result = $service->findValidTemplateById('test-id');

        $this->assertNull($result);
    }

    public function testFindTemplatesBySpuIds(): void
    {
        $service = self::getService(FreightTemplateService::class);

        // 测试空数组
        $result = $service->findTemplatesBySpuIds([]);
        $this->assertIsArray($result);
        foreach ($result as $item) {
            $this->assertIsObject($item);
        }

        // 测试有SPU ID的情况
        $spuIds = ['spu-1', 'spu-2', 'spu-3'];
        $result = $service->findTemplatesBySpuIds($spuIds);
        $this->assertIsArray($result);
        foreach ($result as $item) {
            $this->assertIsObject($item);
        }

        // 验证返回的结果与 findAllValidTemplates() 相同
        // 因为当前实现中，该方法实际上返回所有有效模板
        $allValidTemplates = $service->findAllValidTemplates();
        $this->assertSame($allValidTemplates, $result);
    }
}
