<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Form\StudentType;
use App\Repository\CalendarRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentsManagerController extends AbstractController
{


    private $entitymanager;

    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entitymanager = $entitymanager;
    }

    /**
     * @Route("/students", name="students_manager")
     */
    public function index(StudentRepository $student): Response
    {

        $student = $student->findBy(array(), array('id' => 'ASC'), 8, 0);

        return $this->render('students_manager/index.html.twig', [
            'students' => $student,
        ]);
    }

    /**
     * @Route("/students/add", name="add_students")
     */
    public function addStudent(Request $request): Response
    {
        $form = $this->createForm(StudentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entitymanager->persist($form->getData());
            $this->entitymanager->flush();
            $this->addFlash('success', 'Your student Is created !');
            $this->redirectToRoute('students_manager');
        }

        return $this->render('students_manager/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/students/remove/{id}", name="remove_students")
     */
    public function removeStudent(int $id, StudentRepository $student)
    {

        $student = $student->findBy(['id' => $id]);

        if (empty($student)) {
            $this->addFlash('error', 'Student dont removed');
            return $this->redirectToRoute('students_manager');
        }

        $this->entitymanager->remove($student[0]);
        $this->entitymanager->flush();

        $this->addFlash('success', 'Student is removed');
        return $this->redirectToRoute('students_manager');
    }

    /**
     * @Route("/students/edit/{id}", name="edit_students")
     */
    public function editStudent(int $id, StudentRepository $student, Request $request): Response
    {
        $student = $student->findBy(['id' => $id])[0];

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entitymanager->persist($form->getData());
            $this->entitymanager->flush();
            $this->addFlash('success', 'Your student Is updated !');
            return $this->redirectToRoute('students_manager');
        }

        return $this->render('students_manager/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
