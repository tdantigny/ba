<?php

namespace AppBundle\Core\Services;

/**
 * Class Ad
 * @package AppBundle\Core\Services
 */
class Date
{
    /**
     * Get the french date
     *
     * @param \DateTime $dateTime
     * @return string
     */
    public function getFrenchDate(\DateTime $dateTime)
    {
        $frenchDay = $this->getFrenchDay($dateTime->format('N'));
        $frenchMonth = $this->getFrenchMonth($dateTime->format('n'));

        return $frenchDay.' '.$dateTime->format('d').' '.$frenchMonth.' '.$dateTime->format('Y');
    }
    /**
     * Get the french day of a date
     *
     * @param int $dayNumber
     * @return string
     */
    private function getFrenchDay(int $dayNumber)
    {
        switch ($dayNumber) {
            case 1 :
                $frenchDay = 'Lundi';
                break;
            case 2 :
                $frenchDay = 'Mardi';
                break;
            case 3 :
                $frenchDay = 'Mercredi';
                break;
            case 4 :
                $frenchDay = 'Jeudi';
                break;
            case 5 :
                $frenchDay = 'Vendredi';
                break;
            case 6 :
                $frenchDay = 'Samedi';
                break;
            case 7 :
                $frenchDay = 'Dimanche';
                break;
            default:
                $frenchDay = '';
                break;
        }

        return $frenchDay;
    }

    /**
     * Get the french month of a date
     *
     * @param int $monthNumber
     * @return string
     */
    private function getFrenchMonth(int $monthNumber)
    {
        switch ($monthNumber) {
            case 1 :
                $frenchMonth = 'Janvier';
                break;
            case 2 :
                $frenchMonth = 'Février';
                break;
            case 3 :
                $frenchMonth = 'Mars';
                break;
            case 4 :
                $frenchMonth = 'Avril';
                break;
            case 5 :
                $frenchMonth = 'Mai';
                break;
            case 6 :
                $frenchMonth = 'Juin';
                break;
            case 7 :
                $frenchMonth = 'Juiller';
                break;
            case 8 :
                $frenchMonth = 'Août';
                break;
            case 9 :
                $frenchMonth = 'Septembre';
                break;
            case 10 :
                $frenchMonth = 'Octobre';
                break;
            case 11 :
                $frenchMonth = 'Novembre';
                break;
            case 12 :
                $frenchMonth = 'Décembre';
                break;
            default:
                $frenchMonth = '';
                break;
        }

        return $frenchMonth;
    }
}
