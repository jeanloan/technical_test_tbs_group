<?php

namespace App\Controller;

use App\Business\SubscriptionFetchHandler;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionFetchController extends AbstractController
{
    public function __construct(
        private SubscriptionFetchHandler $subscriptionFetchHandler,
    ) {
    }
    public function index(int $idContact): JsonResponse
    {
        try {

            $subscriptions = $this->subscriptionFetchHandler->handle($idContact);
        } 
        catch (EntityNotFoundException $exception) {

            return $this->json(
                [
                    'error' => $exception->getMessage(),
                ],
                Response::HTTP_NOT_FOUND
            );
        } 
        catch (\Throwable $throwable) {
            
            return $this->json(
                [
                    'error' => "Une erreur est survenue: " . $throwable->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $data = [];
        foreach ($subscriptions as $subscription) {
            $data[] = $subscription->serialize();
        }

        return $this->json(
            $data,
            Response::HTTP_OK
        );
    }
}
