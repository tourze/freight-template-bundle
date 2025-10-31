<?php

declare(strict_types=1);

namespace Tourze\FreightTemplateBundle\Service;

use Knp\Menu\ItemInterface;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\EasyAdminMenuBundle\Service\MenuProviderInterface;
use Tourze\FreightTemplateBundle\Controller\Admin\FreightTemplateCrudController;

readonly class AdminMenu implements MenuProviderInterface
{
    public function __construct(private LinkGeneratorInterface $linkGenerator)
    {
    }

    public function __invoke(ItemInterface $item): void
    {
        if (null === $item->getChild('商品管理')) {
            $item->addChild('商品管理')->setExtra('permission', 'ProductBundle');
        }

        $productManagement = $item->getChild('商品管理');
        if (null !== $productManagement) {
            $productManagement->addChild('运费模板')->setUri($this->linkGenerator->getCurdListPage(FreightTemplateCrudController::class));
        }
    }
}
