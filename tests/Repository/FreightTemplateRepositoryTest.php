<?php

declare(strict_types=1);

namespace Tourze\FreightTemplateBundle\Tests\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\FreightTemplateBundle\Entity\FreightTemplate;
use Tourze\FreightTemplateBundle\Enum\FreightValuationType;
use Tourze\FreightTemplateBundle\Repository\FreightTemplateRepository;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use Tourze\ProductCoreBundle\Enum\DeliveryType;

/**
 * @internal
 */
#[CoversClass(FreightTemplateRepository::class)]
#[RunTestsInSeparateProcesses]
final class FreightTemplateRepositoryTest extends AbstractRepositoryTestCase
{
    protected function createNewEntity(): FreightTemplate
    {
        $entity = new FreightTemplate();
        $entity->setName('Test Freight Template ' . uniqid());
        $entity->setValid(true);
        $entity->setDeliveryType(DeliveryType::EXPRESS);
        $entity->setValuationType(FreightValuationType::FIXED);
        $entity->setCurrency('CNY');
        $entity->setFee('10.00');

        return $entity;
    }

    protected function getRepository(): FreightTemplateRepository
    {
        return self::getService(FreightTemplateRepository::class);
    }

    protected function onSetUp(): void
    {
        // 父类要求实现此方法，但我们可以留空
    }

    public function testSave(): void
    {
        $entity = new FreightTemplate();
        $entity->setName('Test Freight Template');
        $entity->setValid(true);
        $entity->setDeliveryType(DeliveryType::EXPRESS);
        $entity->setValuationType(FreightValuationType::FIXED);
        $entity->setCurrency('CNY');
        $entity->setFee('10.00');

        $entityManager = self::getEntityManager();
        $entityManager->persist($entity);
        $this->assertNotNull($entity->getId());
    }

    public function testSaveAll(): void
    {
        $entities = [];
        for ($i = 1; $i <= 3; ++$i) {
            $entity = new FreightTemplate();
            $entity->setName("Test Freight Template {$i}");
            $entity->setValid(true);
            $entity->setDeliveryType(DeliveryType::EXPRESS);
            $entity->setValuationType(FreightValuationType::FIXED);
            $entity->setCurrency('CNY');
            $entity->setFee('10.00');
            $entities[] = $entity;
        }

        $this->getRepository()->saveAll($entities, false);

        foreach ($entities as $entity) {
            $this->assertNotNull($entity->getId());
        }
    }

    public function testRemove(): void
    {
        $entity = new FreightTemplate();
        $entity->setName('Test Freight Template for Remove');
        $entity->setValid(true);
        $entity->setDeliveryType(DeliveryType::EXPRESS);
        $entity->setValuationType(FreightValuationType::FIXED);
        $entity->setCurrency('CNY');
        $entity->setFee('10.00');

        $this->getRepository()->save($entity);
        $savedId = $entity->getId();

        $this->getRepository()->remove($entity, false);
        $this->getRepository()->flush();

        $found = $this->getRepository()->find($savedId);
        $this->assertNull($found);
    }

    public function testFlush(): void
    {
        $entity = $this->createNewEntity();
        $entityManager = self::getEntityManager();
        $entityManager->persist($entity);

        $this->getRepository()->flush();
        $this->assertNotNull($entity->getId());
    }

    public function testClear(): void
    {
        $entity = $this->createNewEntity();
        $this->getRepository()->save($entity);

        $entityManager = self::getEntityManager();
        $this->assertTrue($entityManager->contains($entity));

        $this->getRepository()->clear();
        $this->assertFalse($entityManager->contains($entity));
    }
}
