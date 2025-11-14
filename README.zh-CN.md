# 运费模板包 (Freight Template Bundle)

[English](README.md) | [中文](README.zh-CN.md)

用于在电商应用中管理运费模板的 Symfony 包。该包为处理运费计算和模板管理提供完整的解决方案。

## 功能特性

- 运费模板管理与验证
- 多种配送方式和计费方式
- EasyAdmin 后台管理集成
- Doctrine ORM 集成与实体映射
- RESTful API 支持
- 全面的验证和约束
- 开发测试数据固定装置

## 系统要求

- PHP 8.1+
- Symfony 6.4+
- Doctrine ORM
- EasyAdmin Bundle

## 安装

### 安装包

```bash
composer require tourze/freight-template-bundle
```

### 注册 Bundle

Bundle 应该由 Symfony Flex 自动注册。如果没有，请在 `config/bundles.php` 中添加：

```php
return [
    // ...
    Tourze\FreightTemplateBundle\FreightTemplateBundle::class => ['all' => true],
];
```

### 运行数据库迁移

```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

### 加载演示数据（可选）

```bash
php bin/console doctrine:fixtures:load --append --group=FreightTemplate
```

## 使用方法

### 服务使用

```php
use Tourze\FreightTemplateBundle\Service\FreightTemplateService;

class YourService
{
    public function __construct(
        private FreightTemplateService $freightTemplateService
    ) {}

    public function calculateShipping(string $templateId): ?FreightTemplate
    {
        // 根据 ID 查找运费模板
        return $this->freightTemplateService->findValidTemplateById($templateId);
    }

    public function getAvailableTemplates(): array
    {
        // 获取所有有效的运费模板
        return $this->freightTemplateService->findAllValidTemplates();
    }
}
```

### 实体使用

```php
use Tourze\FreightTemplateBundle\Entity\FreightTemplate;
use Tourze\FreightTemplateBundle\Enum\FreightValuationType;
use Tourze\ProductCoreBundle\Enum\DeliveryType;

$template = new FreightTemplate();
$template->setName('标准配送');
$template->setDeliveryType(DeliveryType::EXPRESS);
$template->setValuationType(FreightValuationType::FIXED);
$template->setCurrency('CNY');
$template->setFee('15.00');
$template->setValid(true);
```

## API 参考

### FreightTemplateService

| 方法 | 参数 | 返回类型 | 描述 |
|------|------|----------|------|
| `findValidTemplateById()` | `string $templateId` | `?FreightTemplate` | 根据 ID 查找有效模板 |
| `findAllValidTemplates()` | - | `array<FreightTemplate>` | 获取所有有效模板 |
| `findTemplatesBySpuIds()` | `array $spuIds` | `array<FreightTemplate>` | 根据 SPU IDs 查找模板 |

### FreightTemplate 实体

#### 主要属性

- `id`: string - 唯一标识符（雪花 ID）
- `name`: string - 模板名称
- `deliveryType`: DeliveryType - 配送方式
- `valuationType`: FreightValuationType - 计费方式
- `currency`: string - 货币代码（默认：CNY）
- `fee`: string - 运费
- `valid`: bool - 模板是否有效
- `sortNumber`: int - 排序顺序
- `createTime`: DateTime - 创建时间戳
- `updateTime`: DateTime - 最后更新时间戳

#### 枚举类型

**DeliveryType (配送方式)**
- `EXPRESS` - 快递配送
- `PICKUP` - 自提
- `STANDARD` - 标准配送
- `ECONOMY` - 经济配送

**FreightValuationType (计费方式)**
- `FIXED` - 固定费用
- `BY_ITEM` - 按件计费

## 管理界面

访问 `/admin/product/freight-template` 进入运费模板管理界面：

- 创建和编辑运费模板
- 配置配送方式和计费方式
- 管理模板有效性和排序
- 过滤和搜索模板

## 测试

```bash
# 运行所有测试
./vendor/bin/phpunit packages/freight-template-bundle/tests

# 运行 PHPStan 静态分析
php -d memory_limit=2G ./vendor/bin/phpstan analyse packages/freight-template-bundle
```

## 依赖包

- `tourze/product-core-bundle` - 核心产品功能
- `tourze/doctrine-*-bundle` - Doctrine 集成包
- `easycorp/easyadmin-bundle` - 管理界面
- `tourze/easy-admin-enum-field-bundle` - EasyAdmin 枚举字段支持

## 配置

该包开箱即用，配置需求极少。不过你可以自定义某些方面：

```yaml
# config/packages/freight_template.yaml
freight_template:
    default_currency: 'CNY'
    default_valuation_type: 'fixed'
```

## 贡献

1. Fork 仓库
2. 创建功能分支
3. 进行更改
4. 为新功能添加测试
5. 运行测试套件
6. 提交 Pull Request

## 许可证

MIT License