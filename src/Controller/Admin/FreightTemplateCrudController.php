<?php

namespace Tourze\FreightTemplateBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use Tourze\EasyAdminEnumFieldBundle\Field\EnumField;
use Tourze\FreightTemplateBundle\Entity\FreightTemplate;
use Tourze\FreightTemplateBundle\Enum\FreightValuationType;
use Tourze\ProductCoreBundle\Enum\DeliveryType;

/**
 * @phpstan-extends AbstractCrudController<FreightTemplate>
 */
#[AdminCrud(routePath: '/product/freight-template', routeName: 'product_freight_template')]
final class FreightTemplateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FreightTemplate::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('运费模板')
            ->setEntityLabelInPlural('运费模板管理')
            ->setPageTitle('index', '运费模板列表')
            ->setPageTitle('new', '创建运费模板')
            ->setPageTitle('edit', '编辑运费模板')
            ->setPageTitle('detail', '运费模板详情')
            ->setHelp('index', '管理产品运费模板，包括配送方式、计费方式和运费设置')
            ->setDefaultSort(['id' => 'DESC'])
            ->setSearchFields(['id', 'name'])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')->setMaxLength(9999);
        yield TextField::new('name', '模板名称');
        yield ChoiceField::new('deliveryType', '配送方式')
            ->setChoices(array_combine(
                array_map(fn (DeliveryType $case) => $case->getLabel(), DeliveryType::cases()),
                array_map(fn (DeliveryType $case) => $case, DeliveryType::cases())
            ))
        ;
        yield ChoiceField::new('valuationType', '计费方式')
            ->setChoices(array_combine(
                array_map(fn (FreightValuationType $case) => $case->getLabel(), FreightValuationType::cases()),
                array_map(fn (FreightValuationType $case) => $case, FreightValuationType::cases())
            ))
        ;
        yield TextField::new('currency', '币种');
        yield MoneyField::new('fee', '运费')->setCurrency('CNY');
        yield IntegerField::new('sortNumber', '排序');
        yield BooleanField::new('valid', '是否有效');
        yield DateTimeField::new('createTime', '创建时间')->hideOnForm();
        yield DateTimeField::new('updateTime', '更新时间')->hideOnForm();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $deliveryTypeChoices = [];
        foreach (DeliveryType::cases() as $case) {
            $deliveryTypeChoices[$case->getLabel()] = $case->value;
        }

        $valuationTypeChoices = [];
        foreach (FreightValuationType::cases() as $case) {
            $valuationTypeChoices[$case->getLabel()] = $case->value;
        }

        return $filters
            ->add(TextFilter::new('name', '模板名称'))
            ->add(ChoiceFilter::new('deliveryType', '配送方式')->setChoices($deliveryTypeChoices))
            ->add(ChoiceFilter::new('valuationType', '计费方式')->setChoices($valuationTypeChoices))
            ->add(BooleanFilter::new('valid', '是否有效'))
        ;
    }
}
