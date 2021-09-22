<?php

namespace App\Service;

use DateTime;
use App\Repository\StudentRepository;
use App\Repository\CalendarRepository;
use Symfony\Component\Serializer\Serializer;
use function PHPUnit\Framework\stringContains;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class NotificationService extends AbstractController
{

    private $calendar;
    private $student;
    private $normalizer;
    public $notification = array();
    function __construct(CalendarRepository $calendars, StudentRepository $students, NormalizerInterface $normalizer)
    {
        $this->calendar = $calendars;
        $this->student = $students;
        $this->normalizer = $normalizer;
    }

    function Appointment()
    {


        /* 
    RECCUPERER LES RENDEZ VOUS DU MOIS 
    VOIR QUI NA PAS DE RENDEZ VOUS CETTE SEMAINE
    AFFICHER NOTIFICATION
    */

        $student = $this->student->findAll();
        $actualMonth = date('m');
        $actualYear = date('y');
        $weekNumber = date('W');



        foreach ($student as $key => $value) {

            if (!empty($value->getNextAppointment())) {
                if (($value->getNextAppointment()->format('m') != $actualMonth && $actualYear === $value->getNextAppointment()->format('y'))) {
                    $this->notification += [$key => ['message' => $value->getFirstname() . ' need appointment on this month !!!', 'student' => $value, 'type' => 'month-appointment']];
                }

                if ($value->getNextAppointment()->format('W') != $weekNumber && $actualYear === $value->getNextAppointment()->format('y') && $value->getNextAppointment()->format('m') === $actualMonth) {
                    $this->notification += [$key => ['message' => $value->getFirstname() . ' need appoint for this week !!!', 'student' => $value, 'type' => 'week-appointment']];
                }
            } else {
                $this->notification += [$key => ['message' => $value->getFirstname() . ' need first appointment !!!', 'student' => $value, 'type' => 'first-appointment']];
            }
        }

        $notification = $this->normalizer->normalize($this->notification, null, ['groups' => 'post:read']);

        return $notification;
    }

    function findNotification()
    {
        return json_encode($this->Appointment());
    }
}
