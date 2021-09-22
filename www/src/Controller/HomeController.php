<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use App\Service\HomeStatService;
use App\Service\NotificationService;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(StudentRepository $student, HomeStatService $stats, NotificationService $notification): Response
    {
        $student = $student->findBy(array(), array('id' => 'ASC'), 8, 0);

        //* GENERATE STATS FOR HOME PAGE *//

        $numberhourssession =  $stats->totalHoursOfMonth();
        $numberofstudent = $stats->numberOfStudents();
        $nextAppointment = $stats->nextAppointment();
        $eurosforthismonth = $stats->eurosForThisMonth();

        return $this->render('home/index.html.twig', [
            'students' => $student,
            'numberofstudent' => $numberofstudent,
            'numberofhourssession' => $numberhourssession,
            'nextappointment' => $nextAppointment,
            'eurosforthismonth' => $eurosforthismonth,
        ]);
    }
}
