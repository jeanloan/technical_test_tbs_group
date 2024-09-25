<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
class Subscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $beginDate = null;

    #[ORM\ManyToOne(cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne(cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contact $contact = null;

    public function __construct(Product $product, Contact $contact, DateTime $beginDate, DateTime $endDate)
    {
        $this->product = $product;
        $this->contact = $contact;
        $this->beginDate = $beginDate;
        $this->endDate = $endDate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getBeginDate(): ?\DateTimeInterface
    {
        return $this->beginDate;
    }

    public function setBeginDate(\DateTimeInterface $beginDate): static
    {
        $this->beginDate = $beginDate;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;
        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * 
     * @return array
     */
    public function serialize(): array
    {
        return [
            "product" => [
                "label" => $this->product->getLabel()
            ],
            "contact" => [
                "name" => $this->contact->getName(),
                "firstname" => $this->contact->getFirstname(),
            ],
            "beginDate" => $this->beginDate->format('Y-m-d'),
            "endDate" => $this->endDate->format('Y-m-d')
        ];
    }
}
