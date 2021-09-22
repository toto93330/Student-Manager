<?php

namespace App\Controller;

use App\Entity\EmailTemplate;
use Twig\Environment;
use App\Entity\Student;
use App\Form\EmailTemplateType;
use App\Form\SendMailType;
use App\Form\SendBasicMailType;
use App\Service\SendMailService;
use App\Repository\PathRepository;
use App\Repository\MentorRepository;
use App\Repository\CalendarRepository;
use App\Repository\PathProjectRepository;
use App\Repository\EmailTemplateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SendMailController extends AbstractController
{

    private $entityManager;

    function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entityManager = $entitymanager;
    }


    /**
     * @Route("/sendmail", name="send_mail")
     */
    public function index(Request $request, SerializerInterface $serializer, MentorRepository $mentor, SendMailService $mailer, CalendarRepository $calendar, Environment $twig): Response
    {

        // SEND BASIC MAIL WITH SYMFONY MAILLER
        $sendbasicmail = $this->createForm(SendBasicMailType::class);
        $sendbasicmail->handleRequest($request);

        if ($sendbasicmail->isSubmitted() && $sendbasicmail->isValid()) {

            //GET STUDENT EMAIL, SUBJECT AND CONTENT FOR BASIC EMAIL
            $studentemail = $sendbasicmail->get('email')->getData()->getEmail();
            $mailsubject = $sendbasicmail->get('subject')->getData();
            $mailcontent = $sendbasicmail->get('content')->getData();
            //GET MENTOR DATA
            $mentor = $mentor->findAll()[0];

            //SEND MAIL
            $mailer->send($studentemail, $mentor->getEmail(), $mailsubject,  ['content' => $mailcontent]);
        }

        // SEND TEMPLATE EMAIL WITH SYMFONY MAILLER
        $sendmail = $this->createForm(SendMailType::class);
        $sendmail->handleRequest($request);

        // VERIF FORM IS SUBMITTED AND IS VALID
        if ($sendmail->isSubmitted() && $sendmail->isValid()) {

            //GET STUDENT DATA
            $studentData = $sendmail->get('email')->getData();
            $json = $serializer->serialize($studentData, 'json', ['groups' => 'post:mail']);
            $student = json_decode($json);
            //GET MENTOR DATA
            $mentor = $mentor->findAll()[0];

            //GET STUDENT EMAIL, MAIL SUBJECT AND MAIL CONTENT FOR SEND EMAIL
            $studentemail = $studentData->getEmail();
            $mailsubject = $sendmail->get('mail_template')->getData()->getName();
            $mailcontent = html_entity_decode($sendmail->get('content')->getData());

            //GENERATE TEMPLATE FOR SENDING MAIL (IMPORTANT)
            $template = $this->get('twig')->createTemplate($mailcontent);
            $mailcontent = $twig->render($template, [
                'mentor' => $mentor,
                'student' => $student,
            ]);

            //SEND MAIL
            $mailer->send($studentemail, $mentor->getEmail(), $mailsubject,  ['content' => $mailcontent, 'mentor' => $mentor]);
        }

        return $this->render('send_mail/index.html.twig', [
            'sendbasicmail' => $sendbasicmail->createView(),
            'sendmail' => $sendmail->createView(),
        ]);
    }

    /**
     * @Route("/sendmail/all/template", name="all_template")
     */
    public function allTemplate(EmailTemplateRepository $emailtemplate)
    {
        $emailtemplate = $emailtemplate->findBy(array(), array('id' => 'ASC'), 8, 0);

        return $this->render('send_mail/all_template.html.twig', [
            'templates' => $emailtemplate
        ]);
    }

    /**
     * @Route("/sendmail/add/template", name="add_template")
     */
    public function addTemplate(Request $request)
    {
        $form = $this->createForm(EmailTemplateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $template = $form->getData();

            $this->entityManager->persist($template);
            $this->entityManager->flush();

            $this->addFlash('success', 'Your New template is add !');
        }

        return $this->render('send_mail/add_template.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/sendmail/edit/template/{id}", name="edit_template")
     */
    public function editTemplate(Request $request, int $id, EmailTemplateRepository $emailtemplate)
    {

        $emailtemplate = $emailtemplate->findOneBy(['id' => $id]);

        $form = $this->createForm(EmailTemplateType::class, $emailtemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $template = $form->getData();

            $this->entityManager->persist($template);
            $this->entityManager->flush();

            $this->addFlash('success', 'Your New template is edited !');
            return $this->redirectToRoute('all_template');
        }

        return $this->render('send_mail/edit_template.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/sendmail/remove/template/{id}", name="remove_template")
     */
    public function removeTemplate(int $id, EmailTemplateRepository $emailtemplate)
    {
        $emailtemplate = $emailtemplate->findOneBy(['id' => $id]);

        if (empty($emailtemplate)) {
            $this->addFlash('error', 'Your template is not removed !');
            return $this->redirectToRoute('all_template');
        }

        $this->entityManager->remove($emailtemplate);
        $this->entityManager->flush();
        $this->addFlash('success', 'Your email template is removed !');
        return $this->redirectToRoute('all_template');
    }

    /**
     * @Route("/sendmail/ajax/{id}", name="send_mail_ajax")
     */
    public function getSendMailWithAjax(SerializerInterface $serializer, EmailTemplateRepository $repository, int $id)
    {
        $template = $repository->findBy(['id' => $id]);
        $json = $serializer->serialize($template, 'json');

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);

        return  $response;
    }
}
