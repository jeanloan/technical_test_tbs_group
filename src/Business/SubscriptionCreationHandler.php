<?php

namespace App\Business;

use App\DTO\SubscriptionDTO;
use App\Entity\Contact;
use App\Entity\Product;
use App\Entity\Subscription;
use App\Repository\ContactRepository;
use App\Repository\ProductRepository;
use App\Repository\SubscriptionRepository;
use DateTime;

class SubscriptionCreationHandler
{

    public function __construct(
        private SubscriptionRepository $subscriptionRepository,
        private ProductRepository $productRepository,
        private ContactRepository $contactRepository,
    ) {
    }
    public function handle(SubscriptionDTO $subscriptionDTO): void
    {
        $product = $this->productRepository->findOneByLabel($subscriptionDTO->getProduct()->getLabel());

        if(!$product instanceof Product){
            $product = new Product($subscriptionDTO->getProduct()->getLabel());
        }

        $contact = $this->contactRepository->findOneByFullname(
            $subscriptionDTO->getContact()->getName(),
            $subscriptionDTO->getContact()->getFirstname()

        );

        if(!$contact instanceof Contact){
            $contact = new Contact(
                $subscriptionDTO->getContact()->getName(),
                $subscriptionDTO->getContact()->getFirstname()
            );
        }
        
        $this->subscriptionRepository->create(
            new Subscription(
                $product,
                $contact,
                new DateTime($subscriptionDTO->getBeginDate()),
                new DateTime($subscriptionDTO->getEndDate())
            )
        );
    }
}