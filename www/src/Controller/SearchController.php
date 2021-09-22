<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{

    public function index(Request $request)
    {

        $form = $this->createForm(SearchType::class);

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search", name="search_student", methods="POST")
     */
    public function search(Request $request, StudentRepository $student)
    {

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = htmlspecialchars($form->getData()['search']);
            $student = $student->search($data);
        }

        return $this->render('search/search.html.twig', ['datas' => $student]);
    }
}
