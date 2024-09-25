<?php

namespace App\Repository;

use App\Entity\Subscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Subscription>
 */
class SubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    public function create(Subscription $subscription): self
    {
        $this->getEntityManager()->persist($subscription);
        $this->getEntityManager()->flush();
        return $this;
    }

    /**
     * @return Subscription[] || null
     */
    public function findByContact(string $idContact): ?array
    {
        return $this->createQueryBuilder('s')
            ->where('s.contact = :idContact')
            ->setParameter('idContact', $idContact)
            ->getQuery()
            ->getResult();
    }

    public function delete(Subscription $subscription): self
    {

        $this->getEntityManager()->remove($subscription);
        $this->getEntityManager()->flush();
        return $this;
    }

    public function findOneById(int $subscriptionId): ?Subscription
    {
        return $this->createQueryBuilder('s')
            ->where('s.id = :subscriptionId')
            ->setParameter('subscriptionId', $subscriptionId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function update(Subscription $subscription): self
    {
        $this->getEntityManager()->flush();
        return $this;
    }
}
