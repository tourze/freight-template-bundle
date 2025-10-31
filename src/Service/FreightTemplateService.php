<?php

namespace Tourze\FreightTemplateBundle\Service;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\FreightTemplateBundle\Entity\FreightTemplate;
use Tourze\FreightTemplateBundle\Repository\FreightTemplateRepository;

/**
 * 运费模板服务
 */
#[Autoconfigure(public: true)]
final readonly class FreightTemplateService
{
    public function __construct(
        private FreightTemplateRepository $freightTemplateRepository,
    ) {
    }

    /**
     * 根据ID查找有效的运费模板
     */
    public function findValidTemplateById(string $templateId): ?FreightTemplate
    {
        return $this->freightTemplateRepository->findOneBy([
            'id' => $templateId,
            'valid' => true,
        ]);
    }

    /**
     * 查找所有有效的运费模板
     *
     * @return array<FreightTemplate>
     */
    public function findAllValidTemplates(): array
    {
        /** @var array<FreightTemplate> */
        return $this->freightTemplateRepository->createQueryBuilder('a')
            ->where('a.valid = true')
            ->addOrderBy('a.sortNumber', 'ASC')
            ->addOrderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * 根据SPU ID列表查找有效的运费模板
     *
     * 注意: 当前设计中运费模板不与SPU直接关联，
     * 此方法返回所有有效的运费模板供前端选择
     *
     * @param array<string> $spuIds SPU ID数组（当前未使用）
     * @return array<FreightTemplate>
     */
    public function findTemplatesBySpuIds(array $spuIds): array
    {
        // TODO: 如需要与SPU建立关联，需要在FreightTemplate实体中添加SPU关系
        // 当前实现返回所有有效模板
        return $this->findAllValidTemplates();
    }
}
