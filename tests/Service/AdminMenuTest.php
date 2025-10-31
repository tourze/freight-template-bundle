<?php

declare(strict_types=1);

namespace Tourze\FreightTemplateBundle\Tests\Service;

use Knp\Menu\ItemInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Tourze\FreightTemplateBundle\Service\AdminMenu;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminMenuTestCase;

/**
 * @internal
 */
#[CoversClass(AdminMenu::class)]
#[RunTestsInSeparateProcesses]
final class AdminMenuTest extends AbstractEasyAdminMenuTestCase
{
    protected function onSetUp(): void
    {
        // 无需额外设置
    }

    private function createAdminMenu(): AdminMenu
    {
        return self::getService(AdminMenu::class);
    }

    private function createMockItemInterface(): ItemInterface
    {
        $mock = $this->createMock(ItemInterface::class);
        $mock->method('setFactory')->willReturnSelf();
        $mock->method('getChild')->willReturn(null);
        $mock->method('addChild')->willReturnSelf();
        $mock->method('setUri')->willReturnSelf();
        $mock->method('getName')->willReturn('');
        $mock->method('setName')->willReturnSelf();
        $mock->method('getUri')->willReturn(null);
        $mock->method('getLabel')->willReturn('');
        $mock->method('setLabel')->willReturnSelf();
        $mock->method('getExtra')->willReturnArgument(1);
        $mock->method('setExtra')->willReturnSelf();
        $mock->method('getExtras')->willReturn([]);
        $mock->method('setExtras')->willReturnSelf();
        $mock->method('getAttributes')->willReturn([]);
        $mock->method('setAttributes')->willReturnSelf();
        $mock->method('getAttribute')->willReturnArgument(1);
        $mock->method('setAttribute')->willReturnSelf();
        $mock->method('getLinkAttributes')->willReturn([]);
        $mock->method('setLinkAttributes')->willReturnSelf();
        $mock->method('getLinkAttribute')->willReturnArgument(1);
        $mock->method('setLinkAttribute')->willReturnSelf();
        $mock->method('getChildrenAttributes')->willReturn([]);
        $mock->method('setChildrenAttributes')->willReturnSelf();
        $mock->method('getChildrenAttribute')->willReturnArgument(1);
        $mock->method('setChildrenAttribute')->willReturnSelf();
        $mock->method('getLabelAttributes')->willReturn([]);
        $mock->method('setLabelAttributes')->willReturnSelf();
        $mock->method('getLabelAttribute')->willReturnArgument(1);
        $mock->method('setLabelAttribute')->willReturnSelf();
        $mock->method('getDisplayChildren')->willReturn(true);
        $mock->method('setDisplayChildren')->willReturnSelf();
        $mock->method('getParent')->willReturn(null);
        $mock->method('getChildren')->willReturn([]);
        $mock->method('setChildren')->willReturnSelf();
        $mock->method('setParent')->willReturnSelf();
        $mock->method('removeChild')->willReturnSelf();
        $mock->method('getFirstChild')->willReturnSelf();
        $mock->method('getLastChild')->willReturnSelf();
        $mock->method('getRoot')->willReturnSelf();
        $mock->method('isRoot')->willReturn(false);
        $mock->method('hasChildren')->willReturn(false);
        $mock->method('setDisplay')->willReturnSelf();
        $mock->method('isDisplayed')->willReturn(true);
        $mock->method('getLevel')->willReturn(0);
        $mock->method('reorderChildren')->willReturnSelf();
        $mock->method('copy')->willReturnSelf();
        $mock->method('getIterator')->willReturn(new \ArrayIterator([]));
        $mock->method('count')->willReturn(0);
        $mock->method('offsetExists')->willReturn(false);
        $mock->method('offsetGet')->willReturn(null);
        $mock->method('actsLikeFirst')->willReturn(false);
        $mock->method('actsLikeLast')->willReturn(false);
        $mock->method('isFirst')->willReturn(false);
        $mock->method('isLast')->willReturn(false);
        $mock->method('isCurrent')->willReturn(false);
        $mock->method('setCurrent')->willReturnSelf();

        return $mock;
    }

    public function testAdminMenuImplementsInterface(): void
    {
        $adminMenu = $this->createAdminMenu();
        $reflection = new \ReflectionClass($adminMenu);

        $this->assertTrue($reflection->implementsInterface('Tourze\EasyAdminMenuBundle\Service\MenuProviderInterface'));
    }

    public function testAdminMenuConstructor(): void
    {
        $adminMenu = $this->createAdminMenu();
        $this->assertInstanceOf(AdminMenu::class, $adminMenu);
    }

    public function testInvokeWithExistingProductManagement(): void
    {
        $adminMenu = $this->createAdminMenu();

        $freightTemplateItem = $this->createMockItemInterface();

        $addChildCallCount = 0;
        $productManagement = $this->createMock(ItemInterface::class);
        $productManagement->method('getChild')
            ->willReturnCallback(static function (string $name) use ($productManagement): ?ItemInterface {
                return '商品管理' === $name ? $productManagement : null;
            })
        ;
        $productManagement->method('addChild')
            ->willReturnCallback(static function ($child) use ($freightTemplateItem, &$addChildCallCount): ItemInterface {
                ++$addChildCallCount;

                return '运费模板' === $child ? $freightTemplateItem : $freightTemplateItem;
            })
        ;

        // 设置其他必要的方法
        $this->configureBaseMockMethods($productManagement);

        $rootItem = $this->createMock(ItemInterface::class);
        $rootItem->method('getChild')
            ->willReturnCallback(static function (string $name) use ($productManagement): ?ItemInterface {
                return '商品管理' === $name ? $productManagement : null;
            })
        ;

        $this->configureBaseMockMethods($rootItem);

        $adminMenu->__invoke($rootItem);

        $this->assertSame(1, $addChildCallCount, 'addChild should be called once');
    }

    public function testInvokeWithoutProductManagement(): void
    {
        $adminMenu = $this->createAdminMenu();

        $newProductManagement = $this->createMockItemInterface();

        $addChildCallCount = 0;
        $rootItem = $this->createMock(ItemInterface::class);
        $rootItem->method('getChild')
            ->willReturnCallback(static function (string $name): ?ItemInterface {
                return '商品管理' === $name ? null : null;
            })
        ;
        $rootItem->method('addChild')
            ->willReturnCallback(static function ($child) use ($newProductManagement, &$addChildCallCount): ItemInterface {
                ++$addChildCallCount;

                return '商品管理' === $child ? $newProductManagement : $newProductManagement;
            })
        ;

        $this->configureBaseMockMethods($rootItem);

        $adminMenu->__invoke($rootItem);

        $this->assertSame(1, $addChildCallCount, 'addChild should be called once for 商品管理');
    }

    /**
     * 配置 Mock 对象的基础方法
     *
     * @param ItemInterface&MockObject $mock
     */
    private function configureBaseMockMethods(ItemInterface $mock): void
    {
        $mock->method('setFactory')->willReturnSelf();
        $mock->method('setUri')->willReturnSelf();
        $mock->method('getName')->willReturn('');
        $mock->method('setName')->willReturnSelf();
        $mock->method('getUri')->willReturn(null);
        $mock->method('getLabel')->willReturn('');
        $mock->method('setLabel')->willReturnSelf();
        $mock->method('getExtra')->willReturnArgument(1);
        $mock->method('setExtra')->willReturnSelf();
        $mock->method('getExtras')->willReturn([]);
        $mock->method('setExtras')->willReturnSelf();
        $mock->method('getAttributes')->willReturn([]);
        $mock->method('setAttributes')->willReturnSelf();
        $mock->method('getAttribute')->willReturnArgument(1);
        $mock->method('setAttribute')->willReturnSelf();
        $mock->method('getLinkAttributes')->willReturn([]);
        $mock->method('setLinkAttributes')->willReturnSelf();
        $mock->method('getLinkAttribute')->willReturnArgument(1);
        $mock->method('setLinkAttribute')->willReturnSelf();
        $mock->method('getChildrenAttributes')->willReturn([]);
        $mock->method('setChildrenAttributes')->willReturnSelf();
        $mock->method('getChildrenAttribute')->willReturnArgument(1);
        $mock->method('setChildrenAttribute')->willReturnSelf();
        $mock->method('getLabelAttributes')->willReturn([]);
        $mock->method('setLabelAttributes')->willReturnSelf();
        $mock->method('getLabelAttribute')->willReturnArgument(1);
        $mock->method('setLabelAttribute')->willReturnSelf();
        $mock->method('getDisplayChildren')->willReturn(true);
        $mock->method('setDisplayChildren')->willReturnSelf();
        $mock->method('getParent')->willReturn(null);
        $mock->method('getChildren')->willReturn([]);
        $mock->method('setChildren')->willReturnSelf();
        $mock->method('setParent')->willReturnSelf();
        $mock->method('removeChild')->willReturnSelf();
        $mock->method('getFirstChild')->willReturnSelf();
        $mock->method('getLastChild')->willReturnSelf();
        $mock->method('getRoot')->willReturnSelf();
        $mock->method('isRoot')->willReturn(false);
        $mock->method('hasChildren')->willReturn(false);
        $mock->method('setDisplay')->willReturnSelf();
        $mock->method('isDisplayed')->willReturn(true);
        $mock->method('getLevel')->willReturn(0);
        $mock->method('reorderChildren')->willReturnSelf();
        $mock->method('copy')->willReturnSelf();
        $mock->method('getIterator')->willReturn(new \ArrayIterator([]));
        $mock->method('count')->willReturn(0);
        $mock->method('offsetExists')->willReturn(false);
        $mock->method('offsetGet')->willReturn(null);
        $mock->method('actsLikeFirst')->willReturn(false);
        $mock->method('actsLikeLast')->willReturn(false);
        $mock->method('isFirst')->willReturn(false);
        $mock->method('isLast')->willReturn(false);
        $mock->method('isCurrent')->willReturn(false);
        $mock->method('setCurrent')->willReturnSelf();
    }
}
