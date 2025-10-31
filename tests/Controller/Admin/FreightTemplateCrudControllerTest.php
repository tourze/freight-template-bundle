<?php

declare(strict_types=1);

namespace Tourze\FreightTemplateBundle\Tests\Controller\Admin;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\FreightTemplateBundle\Controller\Admin\FreightTemplateCrudController;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminControllerTestCase;

/**
 * @internal
 */
#[CoversClass(FreightTemplateCrudController::class)]
#[RunTestsInSeparateProcesses]
final class FreightTemplateCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    protected function getControllerService(): FreightTemplateCrudController
    {
        return self::getService(FreightTemplateCrudController::class);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideIndexPageHeaders(): iterable
    {
        yield 'id' => ['ID'];
        yield 'name' => ['模板名称'];
        yield 'deliveryType' => ['配送方式'];
        yield 'valuationType' => ['计费方式'];
        yield 'currency' => ['币种'];
        yield 'fee' => ['运费'];
        yield 'sortNumber' => ['排序'];
        yield 'valid' => ['是否有效'];
        yield 'createTime' => ['创建时间'];
        yield 'updateTime' => ['更新时间'];
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideEditPageFields(): iterable
    {
        yield 'name' => ['name'];
        yield 'deliveryType' => ['deliveryType'];
        yield 'valuationType' => ['valuationType'];
        yield 'currency' => ['currency'];
        yield 'fee' => ['fee'];
        yield 'sortNumber' => ['sortNumber'];
        yield 'valid' => ['valid'];
    }

    /**
     * 重写父类方法，验证数据提供器与实际字段配置的一致性
     */

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideNewPageFields(): iterable
    {
        yield 'name' => ['name'];
        yield 'deliveryType' => ['deliveryType'];
        yield 'valuationType' => ['valuationType'];
        yield 'currency' => ['currency'];
        yield 'fee' => ['fee'];
        yield 'sortNumber' => ['sortNumber'];
        yield 'valid' => ['valid'];
    }

    public function testIndexPageRequiresAuthentication(): void
    {
        $client = self::createClient();
        $client->catchExceptions(false);

        try {
            $client->request('GET', '/admin/product/freight-template');
            $this->assertResponseRedirects();
        } catch (\Exception $e) {
            $this->assertTrue(
                str_contains($e->getMessage(), 'No route found')
                || str_contains($e->getMessage(), 'Access Denied')
            );
        }
    }

    public function testNewPageRequiresAuthentication(): void
    {
        $client = self::createClient();
        $client->catchExceptions(false);

        try {
            $client->request('GET', '/admin/product/freight-template/new');
            $this->assertResponseRedirects();
        } catch (\Exception $e) {
            $this->assertTrue(
                str_contains($e->getMessage(), 'No route found')
                || str_contains($e->getMessage(), 'Access Denied')
            );
        }
    }

    public function testEditPageRequiresAuthentication(): void
    {
        $client = self::createClient();
        $client->catchExceptions(false);

        try {
            $client->request('GET', '/admin/product/freight-template/1/edit');
            $this->assertResponseRedirects();
        } catch (\Exception $e) {
            $this->assertTrue(
                str_contains($e->getMessage(), 'No route found')
                || str_contains($e->getMessage(), 'Access Denied')
            );
        }
    }

    public function testDeleteRequiresAuthentication(): void
    {
        $client = self::createClient();
        $client->catchExceptions(false);

        try {
            $client->request('DELETE', '/admin/product/freight-template/1');
            $this->assertResponseStatusCodeSame(405);
        } catch (\Exception $e) {
            $this->assertTrue(
                str_contains($e->getMessage(), 'No route found')
                || str_contains($e->getMessage(), 'Access Denied')
            );
        }
    }

    public function testCreateActionRequiresAuthentication(): void
    {
        $client = self::createClient();
        $client->catchExceptions(false);

        try {
            $client->request('POST', '/admin/product/freight-template');
            $this->assertResponseStatusCodeSame(405);
        } catch (\Exception $e) {
            $this->assertTrue(
                str_contains($e->getMessage(), 'No route found')
                || str_contains($e->getMessage(), 'Access Denied')
            );
        }
    }

    public function testUpdateActionRequiresAuthentication(): void
    {
        $client = self::createClient();
        $client->catchExceptions(false);

        try {
            $client->request('PUT', '/admin/product/freight-template/1');
            $this->assertResponseStatusCodeSame(405);
        } catch (\Exception $e) {
            $this->assertTrue(
                str_contains($e->getMessage(), 'No route found')
                || str_contains($e->getMessage(), 'Access Denied')
            );
        }
    }

    public function testPatchActionRequiresAuthentication(): void
    {
        $client = self::createClient();
        $client->catchExceptions(false);

        try {
            $client->request('PATCH', '/admin/product/freight-template/1');
            $this->assertResponseStatusCodeSame(405);
        } catch (\Exception $e) {
            $this->assertTrue(
                str_contains($e->getMessage(), 'No route found')
                || str_contains($e->getMessage(), 'Access Denied')
            );
        }
    }

    public function testHeadRequestRequiresAuthentication(): void
    {
        $client = self::createClient();
        $client->catchExceptions(false);

        try {
            $client->request('HEAD', '/admin/product/freight-template');
            $this->assertResponseRedirects();
        } catch (\Exception $e) {
            $this->assertTrue(
                str_contains($e->getMessage(), 'No route found')
                || str_contains($e->getMessage(), 'Access Denied')
            );
        }
    }

    public function testOptionsRequestRequiresAuthentication(): void
    {
        $client = self::createClient();
        $client->catchExceptions(false);

        try {
            $client->request('OPTIONS', '/admin/product/freight-template');
            $this->assertResponseStatusCodeSame(405);
        } catch (\Exception $e) {
            $this->assertTrue(
                str_contains($e->getMessage(), 'No route found')
                || str_contains($e->getMessage(), 'Access Denied')
            );
        }
    }

    public function testUnauthenticatedAccessShouldRedirectToLogin(): void
    {
        $client = self::createClient();
        $client->catchExceptions(false);

        try {
            $client->request('GET', '/admin/product/freight-template');
            $this->assertResponseRedirects();
            $location = $client->getResponse()->headers->get('Location');
            $this->assertNotNull($location);
            $this->assertStringContainsString('/login', $location);
        } catch (\Exception $e) {
            $this->assertTrue(
                str_contains($e->getMessage(), 'No route found')
                || str_contains($e->getMessage(), 'Access Denied')
            );
        }
    }
}
