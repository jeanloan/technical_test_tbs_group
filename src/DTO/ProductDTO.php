<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ProductDTO
{
    #[Assert\NotBlank(message: "Le label du produit est obligatoire")]
    public ?string $label = null;

    public function getLabel(): ?string{
        return $this->label;
    }

    public function setLabel(?string $label): void {
        $this->label = $label;
    }
}
