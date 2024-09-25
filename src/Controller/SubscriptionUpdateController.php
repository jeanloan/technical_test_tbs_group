<?php

namespace App\Controller;

use App\Business\SubscriptionUpdateHandler;
use App\DTO\SubscriptionDTO;
use App\Form\SubscriptionType;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionUpdateController extends AbstractController
{

    public function __construct(
        private FormFactoryInterface $formFactory,
        private SubscriptionUpdateHandler $subscriptionUpdateHandler
    ) {
    }

    public function index(Request $request, int $idSubscription): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Vérifier si les données JSON sont valides
        if (JSON_ERROR_NONE !== json_last_error() || !is_array($data)) {
            return $this->json(['error' => 'Données JSON invalides.'], Response::HTTP_BAD_REQUEST);
        }

        $form = $this->formFactory->create(
            SubscriptionType::class,
            new SubscriptionDTO(),
            ['method' => 'POST']
        );

        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $error = $this->getFirstFormError($form);
            return $this->json(['error' => $error], Response::HTTP_BAD_REQUEST);
        }

        $subscriptionDTO = $form->getData();

        try {
            $subscriptionDetailsChanged = $this->subscriptionUpdateHandler->handle($idSubscription, $subscriptionDTO);
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

        if(!$subscriptionDetailsChanged){
            
            return $this->json([
                'message' => 'Les informations de la souscription sont les mêmes.',
            ], Response::HTTP_OK);
        }

        return $this->json([
            'message' => 'Souscription modifiée avec succès.',
        ], Response::HTTP_OK);
    }

    private function getFirstFormError(\Symfony\Component\Form\FormInterface $form): string
    {
        foreach ($form->getErrors(true) as $error) {
            if ($error instanceof \Symfony\Component\Form\FormError) {
                return $error->getMessage();
            }
        }

        return 'Une erreur inconnue est survenue.';
    }
}
