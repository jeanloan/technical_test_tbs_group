<?php

namespace App\Controller;

use App\Business\SubscriptionRemovalHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionRemovalController extends AbstractController
{

    public function __construct(
        private SubscriptionRemovalHandler $subscriptionRemovalHandler,
    ) {
    }
    public function index(int $idSubscription): JsonResponse
    {

        try {
            $this->subscriptionRemovalHandler->handle($idSubscription);
        } catch (EntityNotFoundException $exception) {

            return $this->json(
                [
                    'error' => $exception->getMessage(),
                ],
                Response::HTTP_NOT_FOUND
            );
        } catch (\Throwable $throwable) {

            return $this->json(
                [
                    'error' => "Une erreur est survenue: " . $throwable->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        return $this->json(
            [
                'message' => 'Souscription supprimée avec succès.',
            ],
            Response::HTTP_OK
        );
    }
}
