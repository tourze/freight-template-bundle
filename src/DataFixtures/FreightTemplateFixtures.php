<?php

declare(strict_types=1);

namespace Tourze\FreightTemplateBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Tourze\FreightTemplateBundle\Entity\FreightTemplate;
use Tourze\FreightTemplateBundle\Enum\FreightValuationType;
use Tourze\ProductCoreBundle\Enum\DeliveryType;

final class FreightTemplateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $template1 = new FreightTemplate();
        $template1->setName('标准快递');
        $template1->setDeliveryType(DeliveryType::EXPRESS);
        $template1->setValuationType(FreightValuationType::BY_ITEM);
        $template1->setCurrency('CNY');
        $template1->setFee('10.00');
        $template1->setValid(true);
        $manager->persist($template1);

        $template2 = new FreightTemplate();
        $template2->setName('门店自提');
        $template2->setDeliveryType(DeliveryType::STORE);
        $template2->setValuationType(FreightValuationType::FIXED);
        $template2->setCurrency('CNY');
        $template2->setFee('0.00');
        $template2->setValid(true);
        $manager->persist($template2);

        $manager->flush();
    }
}
