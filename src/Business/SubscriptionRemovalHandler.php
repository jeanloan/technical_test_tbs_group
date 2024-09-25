<?php

namespace App\Business;

use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityNotFoundException;

class SubscriptionRemovalHandler
{

    public function __construct(
        private SubscriptionRepository $subscriptionRepository,
    ) {}

    /**
     * @throws EntityNotFoundException
     */
    public function handle(int $idSubscription): void
    {
        $subscription = $this->subscriptionRepository->findOneById($idSubscription);

        if (!$subscription instanceof Subscription) {
            throw new EntityNotFoundException("Aucune souscription trouvée avec l'id: " .$idSubscription ." !");
        }

        $this->subscriptionRepository->delete($subscription);
    }
}