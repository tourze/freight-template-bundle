<?php

namespace Tourze\FreightTemplateBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\Arrayable\AdminArrayInterface;
use Tourze\Arrayable\ApiArrayInterface;
use Tourze\DoctrineHelper\SortableTrait;
use Tourze\DoctrinePrecisionBundle\Attribute\PrecisionColumn;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use Tourze\DoctrineTrackBundle\Attribute\TrackColumn;
use Tourze\DoctrineUserBundle\Traits\BlameableAware;
use Tourze\FreightTemplateBundle\Enum\FreightValuationType;
use Tourze\FreightTemplateBundle\Repository\FreightTemplateRepository;
use Tourze\ProductCoreBundle\Enum\DeliveryType;

/**
 * @see https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent/API/freight/update_freight_template.html
 *
 * @implements ApiArrayInterface<string, mixed>
 * @implements AdminArrayInterface<string, mixed>
 */
#[ORM\Entity(repositoryClass: FreightTemplateRepository::class)]
#[ORM\Table(name: 'product_freight_template', options: ['comment' => '运费模板'])]
class FreightTemplate implements \Stringable, ApiArrayInterface, AdminArrayInterface
{
    use BlameableAware;
    use TimestampableAware;
    use SnowflakeKeyAware;
    use SortableTrait;

    #[TrackColumn]
    #[Groups(groups: ['admin_curd', 'restful_read', 'restful_read', 'restful_write'])]
    #[ORM\Column(type: Types::BOOLEAN, nullable: true, options: ['comment' => '有效', 'default' => 0])]
    #[Assert\Type(type: 'bool')]
    private ?bool $valid = false;

    #[Groups(groups: ['admin_curd', 'restful_read'])]
    #[ORM\Column(type: Types::STRING, length: 100, options: ['comment' => '名称'])]
    #[Assert\NotBlank(message: '名称不能为空')]
    #[Assert\Length(max: 100, maxMessage: '名称长度不能超过 {{ limit }} 个字符')]
    private string $name;

    #[ORM\Column(length: 40, enumType: DeliveryType::class, options: ['comment' => '配送方式'])]
    #[Assert\Choice(callback: [DeliveryType::class, 'cases'])]
    private ?DeliveryType $deliveryType = null;

    #[Groups(groups: ['admin_curd'])]
    #[ORM\Column(length: 40, enumType: FreightValuationType::class, options: ['comment' => '计费方式'])]
    #[Assert\Choice(callback: [FreightValuationType::class, 'cases'])]
    private ?FreightValuationType $valuationType = null;

    #[ORM\Column(type: Types::STRING, length: 10, options: ['default' => 'CNY', 'comment' => '币种'])]
    #[Assert\Length(max: 10, maxMessage: '币种长度不能超过 {{ limit }} 个字符')]
    private ?string $currency = null;

    #[PrecisionColumn]
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true, options: ['comment' => '费用'])]
    #[Assert\PositiveOrZero(message: '费用必须大于等于0')]
    #[Assert\Length(max: 13, maxMessage: '费用不能超过 {{ limit }} 个字符')]
    #[Assert\Regex(pattern: '/^\d+(\.\d{1,2})?$/', message: '费用格式不正确')]
    private ?string $fee = null;

    public function __toString(): string
    {
        if (null === $this->getId() || '' === $this->getId()) {
            return '';
        }

        return "{$this->getName()}";
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(?bool $valid): void
    {
        $this->valid = $valid;
    }

    /**
     * @return array<string, mixed>
     */
    public function retrieveApiArray(): array
    {
        $stores = [];
        // Store functionality removed - StoreBundle not available

        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'deliveryType' => $this->getDeliveryType()?->value,
            'stores' => $stores,
            'currency' => $this->getCurrency(),
            'fee' => $this->getFee(),
        ];
    }

    /**
     * @return Collection<int, mixed>
     */
    public function getStores(): Collection
    {
        // Store functionality removed - StoreBundle not available
        return new ArrayCollection();
    }

    public function getDeliveryType(): ?DeliveryType
    {
        return $this->deliveryType;
    }

    public function setDeliveryType(DeliveryType $deliveryType): void
    {
        $this->deliveryType = $deliveryType;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    public function getFee(): ?string
    {
        return $this->fee;
    }

    public function setFee(?string $fee): void
    {
        $this->fee = $fee;
    }

    /**
     * @return array<string, mixed>
     */
    public function retrieveAdminArray(): array
    {
        return [
            'id' => $this->getId(),
            'createTime' => $this->getCreateTime()?->format('Y-m-d H:i:s'),
            'updateTime' => $this->getUpdateTime()?->format('Y-m-d H:i:s'),
            ...$this->retrieveSortableArray(),
            'name' => $this->getName(),
            'deliveryType' => $this->getDeliveryType()?->value,
            'currency' => $this->getCurrency(),
            'fee' => $this->getFee(),
            'valuationType' => $this->getValuationType()?->value,
        ];
    }

    public function getValuationType(): ?FreightValuationType
    {
        return $this->valuationType;
    }

    public function setValuationType(FreightValuationType $valuationType): void
    {
        $this->valuationType = $valuationType;
    }
}
