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
use Doctrine\ORM\EntityNotFoundException;

class SubscriptionUpdateHandler
{
    public function __construct(
        private SubscriptionRepository $subscriptionRepository,
        private ProductRepository $productRepository,
        private ContactRepository $contactRepository,
    ) {
    }

    public function handle(int $idSubscription, SubscriptionDTO $subscriptionDTO): bool
    {
        $subscription = $this->subscriptionRepository->findOneById($idSubscription);

        if (!$subscription instanceof Subscription) {
            throw new EntityNotFoundException("Aucune souscription trouvée avec l'id: " . $idSubscription . " !");
        }

        $beginDate = new DateTime($subscriptionDTO->getBeginDate());
        $endDate = new DateTime($subscriptionDTO->getEndDate());
        $subscriptionDetailsChanged = false;

        if ($subscription->getBeginDate() != $beginDate) {

            $subscription->setBeginDate($beginDate);
            $subscriptionDetailsChanged = true;

        }

        if ($subscription->getEndDate() != $endDate) {

            $subscription->setEndDate($endDate);
            $subscriptionDetailsChanged = true;
        }

        if ($subscription->getProduct() != $subscriptionDTO->getProduct()) {

            $subscription->setProduct(
                new Product(
                    $subscriptionDTO->getProduct()->getLabel()
                )
            );
            $subscriptionDetailsChanged = true;

        }

        if ($subscription->getContact() != $subscriptionDTO->getContact()) {

            $subscription->setContact(
                new Contact(
                    $subscriptionDTO->getContact()->getName(),
                    $subscriptionDTO->getContact()->getFirstname()
                )
            );
            $subscriptionDetailsChanged = true;
        }

        if (!$subscriptionDetailsChanged) {
            return $subscriptionDetailsChanged;
        }

        $contact = $this->contactRepository->findOneByFullname(
            $subscription->getContact()->getName(),
            $subscription->getContact()->getFirstname(),
        );

        if ($contact instanceof Contact) {
            $subscription->setContact($contact);
        }

        $product = $this->productRepository->findOneByLabel(
            $subscription->getProduct()->getLabel(),
        );

        if ($product instanceof Product) {
            $subscription->setProduct($product);
        }

        $this->subscriptionRepository->update($subscription);
        return $subscriptionDetailsChanged;
    }
}
