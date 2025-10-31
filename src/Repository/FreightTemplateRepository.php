<?php

namespace Tourze\FreightTemplateBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\FreightTemplateBundle\Entity\FreightTemplate;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;

/**
 * @extends ServiceEntityRepository<FreightTemplate>
 */
#[AsRepository(entityClass: FreightTemplate::class)]
final class FreightTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FreightTemplate::class);
    }

    public function save(FreightTemplate $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FreightTemplate $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * 批量保存
     *
     * @param array<FreightTemplate> $entities
     */
    public function saveAll(array $entities, bool $flush = true): void
    {
        foreach ($entities as $entity) {
            $this->getEntityManager()->persist($entity);
        }

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * 刷新实体管理器
     */
    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * 清空实体管理器
     */
    public function clear(): void
    {
        $this->getEntityManager()->clear();
    }
}
