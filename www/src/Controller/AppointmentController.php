<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Form\CalendarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AppointmentController extends AbstractController
{

    public $serializer;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Calendar::class);
    }

    /**
     * @Route("/appointment", name="appointment")
     */
    public function index(EntityManagerInterface $entitymanager, Request $request): Response
    {

        //FIND APPOINTMENT FOR FULLCALENDAR

        $appointments = $this->repository->findAll();
        $rdvs = [];

        foreach ($appointments as $appointment) {
            $rdvs[] = [
                'id' => $appointment->getId(),
                'title' => $appointment->getStudent()->getFirstname() . ' ' . $appointment->getStudent()->getlastname() . ' : ' . $appointment->getContent(),
                'description' => $appointment->getContent(),
                'start' => $appointment->getStart()->format('Y-m-d H:i:s'),
                'end' => $appointment->getEnd()->format('Y-m-d H:i:s'),
                'backgroundColor' => $appointment->getBackgroundColor(),
                'borderColor' => $appointment->getBorderColor(),
                'textColor' => $appointment->getTextColor(),
                'allDay' => $appointment->getAllDay(),
            ];
        }

        $data = Json_encode($rdvs);

        // ON SUBMIT FORM 
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $appointment = $form->getData();
            $findtimeexist = $this->repository->findBy(['start' => $appointment->getStart()]);

            // IF APPOINTMENT EXIST RETURN FLASH ALERT
            if (!empty($findtimeexist)) {
                $this->addFlash('alert', 'Oh Men !!! An appointement is allready exist on this is hours!');
                return $this->redirectToRoute('appointment');
            }


            // UPDATE STUDENT APPOINTMENT NEXT AND LAST 
            $student = $appointment->getStudent();

            $student->setLastAppointment($student->getNextAppointment());
            $student->setNextAppointment($appointment->getStart());

            $entitymanager->persist($student);
            $entitymanager->flush();

            //ADD NEW APPOINTMENT ON DATABASE
            $entitymanager->persist($appointment);
            $entitymanager->flush();
            $this->addFlash('success', 'Congratulation your new Appointment is created!');
        }

        //TAKE 8 LAST APPOINTMENT
        $findappointments = $this->repository->findBy(
            array(),
            array('id' => 'ASC'),
            8,
            0
        );

        return $this->render('appointment/index.html.twig', [
            'form' => $form->createView(),
            'data' => $data,
            'appointment' => $findappointments,
        ]);
    }


    /**
     * @Route("/appointment/ajax/{id}", name="appointment_ajax", methods={"GET"})
     */
    public function loadMoreAppointmentWithAjax(int $id, SerializerInterface $serializer)
    {

        $appointments = $this->repository->findBy(
            array(),
            array('id' => 'ASC'),
            8,
            ($id - 1)
        );

        $json = $serializer->serialize($appointments, 'json', ['groups' => 'post:read']);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);

        return  $response;
    }

    /**
     * @Route("/appointment/remove/{id}", name="appointment_remove", methods={"GET"})
     */
    public function removeAppointment(int $id, EntityManagerInterface $entitymanager)
    {
        //TAKE APPOINTMENT BY ID
        $appointment = $this->repository->findBy(["id" => $id]);

        if (empty($appointment)) {
            $this->addFlash('error', 'Your appointment is not removed!');
            return $this->redirectToRoute('appointment');
        }

        $entitymanager->remove($appointment[0]);
        $entitymanager->flush();

        $this->addFlash('success', 'Your Appointment Is Removed !');
        return $this->redirectToRoute('appointment');
    }

    /**
     * @Route("/appointment/edit/{id}", name="appointment_edit")
     */
    public function editAppointment(int $id, EntityManagerInterface $entitymanager, Request $request)
    {
        //TAKE APPOINTMENT BY ID
        $appointment = $this->repository->findBy(["id" => $id]);
        $student = $appointment[0]->getStudent();

        if (empty($appointment)) {
            $this->addFlash('error', 'Your appointment dont\'t not exist!');
            return $this->redirectToRoute('appointment');
        }

        $form = $this->createForm(CalendarType::class, $appointment[0]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager->persist($student->setNextAppointment($form->getData()->getStart()));
            $entitymanager->flush();

            $entitymanager->persist($form->getData());
            $entitymanager->flush();
            $this->addFlash('success', 'Your Appointment Is Updated !');
            $this->redirectToRoute('appointment');
        }

        return $this->render('appointment/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
