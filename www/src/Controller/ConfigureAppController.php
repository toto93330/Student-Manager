<?php

namespace App\Controller;

use App\Form\SettingAppType;
use App\Repository\MentorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ConfigureAppController extends AbstractController
{
    private $entitymanager;

    function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entitymanager = $entitymanager;
    }

    /**
     * @Route("/config", name="configure_app")
     */
    public function index(MentorRepository $mentor, Request $request): Response
    {


        $mentor = $mentor->findAll();

        if (!empty($mentor)) {
            $form = $this->createForm(SettingAppType::class, $mentor[0]);
        } else {
            $form = $this->createForm(SettingAppType::class);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form  = $form->getData();
            $this->entitymanager->persist($form);
            $this->entitymanager->flush();
            $this->addFlash('success', 'Your Setting is edited !');
            $this->redirectToRoute('configure_app');
        }

        return $this->render('configure_app/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/config/env", name="configure_env")
     */
    public function OpenEnv(MentorRepository $mentor, Request $request)
    {
        exec("C:\AnthonyAlves\StudentManager\www\.env");
        return $this->redirectToRoute('home');
    }
}
