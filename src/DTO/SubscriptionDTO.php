<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class SubscriptionDTO
{
    #[Assert\Valid()]
    private ?ContactDTO $contact = null;

    #[Assert\Valid()]
    private ?ProductDTO $product = null;

    #[Assert\NotBlank(message: "La date de début est obligatoire.")]
    #[Assert\Date(message: "La date de début doit être une date valide.")]
    private ?string $beginDate = null;

    #[Assert\NotBlank(message: "La date de fin est obligatoire.")]
    #[Assert\Date(message: "La date de fin doit être une date valide.")]
    #[Assert\GreaterThan(
        propertyPath: 'beginDate',
        message: "La date de fin doit être postérieure à la date de début"
    )]
    private ?string $endDate = null;

    // Getters and Setters

    public function getContact(): ?ContactDTO
    {
        return $this->contact;
    }

    public function setContact(?ContactDTO $contact): self
    {
        $this->contact = $contact;
        return $this;
    }

    public function getProduct(): ?ProductDTO
    {
        return $this->product;
    }

    public function setProduct(?ProductDTO $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function getBeginDate(): ?string
    {
        return $this->beginDate;
    }

    public function setBeginDate(?string $beginDate): self
    {
        $this->beginDate = $beginDate;
        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

}
