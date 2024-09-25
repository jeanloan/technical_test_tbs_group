<?php

namespace App\Business;
use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityNotFoundException;

class SubscriptionFetchHandler
{
    public function __construct(
        private SubscriptionRepository $subscriptionRepository,
    ) {
    }

    /**
     * @throws EntityNotFoundException
     * @return Subscription[]
     */
    public function handle(int $idContact): array
    {
        $subscriptions = $this->subscriptionRepository->findByContact($idContact);

        if (count($subscriptions) === 0) {
            throw new EntityNotFoundException("Aucune souscripton n'est rattachée au contact avec l'id: " .$idContact ." !");
        }

        return $subscriptions;
    }
}