<?php

namespace App\Service;

use App\Entity\Calendar;
use App\Repository\CalendarRepository;
use App\Repository\StudentRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeStatService extends AbstractController
{

    private $calendar;
    private $students;

    function __construct(CalendarRepository $calendar, StudentRepository $students)
    {
        $this->students = $students;
        $this->calendar = $calendar;
    }

    /**
     * RETURN TOTAL OF STUDENT
     * @return int 
     */
    public function numberOfStudents(): int
    {
        $students = $this->students->findAll();
        return count($students);
    }

    /**
     * AUTO FORMAT HOURS BY MINUTES
     * @param mixed $time 
     * @param string $format 
     * @return void|string 
     */
    function convertToHoursMins($time, $data, $format = '%02d:%02d')
    {

        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, ($hours + $data), $minutes);
    }

    /**
     * RETURN TOTAL HOURS OF MONTH
     * @return void|string 
     */
    public function totalHoursOfMonth()
    {

        $hours = 0;
        $minutes = 0;
        $calendar = $this->calendar->findAll();

        $actualmonth = (new \DateTime())->format('m');


        for ($i = 0; $i < count($calendar); $i++) {

            if ($calendar[$i]->getStart()->format('m') === $actualmonth) {
                $hours += ($calendar[$i]->getEnd()->diff($calendar[$i]->getStart())->h);
                $minutes += ($calendar[$i]->getEnd()->diff($calendar[$i]->getStart())->i);
            }
        }

        return $this->convertToHoursMins($minutes, $hours, '%02d:%02d');
    }

    /**
     * RETURN NEXT STUDENT APPOINTMENT
     * @return Calendar|null 
     */
    public function nextAppointment()
    {
        $appointment = array();
        $index = 0;
        $calendar = $this->calendar->findAll();

        $actualmonth = (new \DateTime())->format('m');

        for ($i = 0; $i < count($calendar); $i++) {

            if (($calendar[$i]->getStart()->format('m') == $actualmonth) && ($calendar[$i]->getValidate() == false)) {

                $appointment += [$index => $calendar[$i]];
                $index++;
            }
        }

        if (empty($appointment)) {
            return null;
        } else {
            return $appointment[0];
        }
    }

    /**
     * TAKE EUROS FOR THIS MONTH
     * @return mixed 
     */
    public function eurosForThisMonth(): float
    {

        $totalmoney = 0;

        $calendar = $this->calendar->findAll();

        $actualmonth = (new \DateTime())->format('m');



        for ($i = 0; $i < count($calendar); $i++) {

            if ($calendar[$i]->getStart()->format('m') == $actualmonth) {
                $totalmoney += ($calendar[$i]->getStudent()->getProject()->getRenumerate() * (intval($calendar[$i]->getEnd()->diff($calendar[$i]->getStart())->h . '.' . $calendar[$i]->getEnd()->diff($calendar[$i]->getStart())->i)));
            }
        }

        return $totalmoney;
    }
}
