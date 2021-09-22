<?php

namespace App\Controller;

use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    /**
     * @Route("/notifications", name="notifications")
     */
    public function home(NotificationService $notification): Response
    {
        $notification = $notification->Appointment();

        return $this->render('notification/home.html.twig', [
            'notification' => $notification,
        ]);
    }

    public function index(NotificationService $notification): Response
    {
        $notification = count($notification->Appointment());

        return $this->render('notification/index.html.twig', [
            'notification' => $notification,
        ]);
    }

    public function notification(NotificationService $notification): Response
    {
        $notification = $notification->Appointment();

        return $this->render('notification/notification.html.twig', [
            'notification' => $notification,
        ]);
    }
}
