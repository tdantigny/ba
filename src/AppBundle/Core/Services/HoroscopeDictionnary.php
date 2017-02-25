<?php

namespace AppBundle\Core\Services;

use AppBundle\Core\Exception\CustomException;

/**
 * Class HoroscopeDictionnary
 * @package AppBundle\Core\Services
 */
class HoroscopeDictionnary
{
    const BELIER = 'aries';
    const TAUREAU = 'taurus';
    const GEMEAU = 'gemini';
    const CANCER = 'cancer';
    const LION = 'lion';
    const VIERGE = 'virgin';
    const BALANCE = 'balance';
    const SCORPION = 'scorpio';
    const SAGITTAIRE = 'sagittarius';
    const CAPRICORNE = 'capricorn';
    const VERSEAU = 'aquarius';
    const POISSONS = 'pisces';

    /**
     * @var array
     */
    private $urlsHorosocope;

    /**
     * @var array
     */
    private $periodHoroscope;

    /**
     * Horoscope constructor.
     * @param array $urlsHorosocope
     */
    public function __construct(array $urlsHorosocope, array $periodHoroscope)
    {
        $this->urlsHorosocope = $urlsHorosocope;
        $this->periodHoroscope = $periodHoroscope;
    }

    /**
     * Convert type name in french
     *
     * @param string $type
     * @return string
     * @throws CustomException
     */
    public function getTypeEnglishToFrench(string $type)
    {
        switch ($type) {
            case self::BELIER:
                $url = 'belier';
                break;

            case self::TAUREAU:
                $url = 'taureau';
                break;

            case self::GEMEAU:
                $url = 'gemeau';
                break;

            case self::CANCER:
                $url = 'cancer';
                break;

            case self::LION:
                $url = 'lion';
                break;

            case self::VIERGE:
                $url = 'vierge';
                break;

            case self::BALANCE:
                $url = 'balance';
                break;

            case self::SCORPION:
                $url = 'scorpion';
                break;

            case self::SAGITTAIRE:
                $url = 'sagittaire';
                break;

            case self::CAPRICORNE:
                $url = 'capricorne';
                break;

            case self::VERSEAU:
                $url = 'verseau';
                break;

            case self::POISSONS:
                $url = 'poissons';
                break;

            default:
                throw new CustomException('Type not found', 0);
                break;
        }

        return $url;
    }

    /**
     * Get the url from french type
     *
     * @param string $type
     * @return string
     * @throws CustomException
     */
    public function getUrlFromFrenchType(string $type)
    {
        switch ($type) {
            case 'belier':
                $url = $this->urlsHorosocope[self::BELIER];
                break;

            case 'taureau':
                $url = $this->urlsHorosocope[self::TAUREAU];
                break;

            case 'gemeau':
                $url = $this->urlsHorosocope[self::GEMEAU];
                break;

            case 'cancer':
                $url = $this->urlsHorosocope[self::CANCER];
                break;

            case 'lion':
                $url = $this->urlsHorosocope[self::LION];
                break;

            case 'vierge':
                $url = $this->urlsHorosocope[self::VIERGE];
                break;

            case 'balance':
                $url = $this->urlsHorosocope[self::BALANCE];
                break;

            case 'scorpion':
                $url = $this->urlsHorosocope[self::SCORPION];
                break;

            case 'sagittaire':
                $url = $this->urlsHorosocope[self::SAGITTAIRE];
                break;

            case 'capricorne':
                $url = $this->urlsHorosocope[self::CAPRICORNE];
                break;

            case 'verseau':
                $url = $this->urlsHorosocope[self::VERSEAU];
                break;

            case 'poissons':
                $url = $this->urlsHorosocope[self::POISSONS];
                break;

            default:
                throw new CustomException('Type not found', 0);
                break;
        }

        return $url;
    }

    /**
     * Get the url from french type
     *
     * @param string $type
     * @return string
     * @throws CustomException
     */
    public function getTypeFrenchToEnglish(string $type)
    {
        switch ($type) {
            case 'belier':
                $type = self::BELIER;
                break;

            case 'taureau':
                $type = self::TAUREAU;
                break;

            case 'gemeau':
                $type = self::GEMEAU;
                break;

            case 'cancer':
                $type = self::CANCER;
                break;

            case 'lion':
                $type = self::LION;
                break;

            case 'vierge':
                $type = self::VIERGE;
                break;

            case 'balance':
                $type = self::BALANCE;
                break;

            case 'scorpion':
                $type = self::SCORPION;
                break;

            case 'sagittaire':
                $type = self::SAGITTAIRE;
                break;

            case 'capricorne':
                $type = self::CAPRICORNE;
                break;

            case 'verseau':
                $type = self::VERSEAU;
                break;

            case 'poissons':
                $type = self::POISSONS;
                break;

            default:
                throw new CustomException('Type not found', 0);
                break;
        }

        return $type;
    }

    /**
     * Get all type in an array
     *
     * @return array
     */
    public function getAllType()
    {
        return [
            self::BELIER,
            self::TAUREAU,
            self::GEMEAU,
            self::CANCER,
            self::LION,
            self::VIERGE,
            self::BALANCE,
            self::SCORPION,
            self::SAGITTAIRE,
            self::CAPRICORNE,
            self::VERSEAU,
            self::POISSONS,
        ];
    }

    /**
     * Get horoscope name according to the birth date of the current user
     *
     * @param \DateTime $birthDate
     * @return string
     */
    public function getTypeByDate(\DateTime $birthDate)
    {
        foreach ($this->periodHoroscope as $type => $period) {
            $lowerBound = new \DateTime($period['start']);
            $upperBound = new \DateTime($period['end']);
            $newBirthDate = new \DateTime($birthDate->format('M d'));
            if ($lowerBound < $upperBound) {
                $between = $lowerBound <= $newBirthDate && $newBirthDate <= $upperBound;
            } else {
                $between = $newBirthDate <= $upperBound || $newBirthDate >= $lowerBound;
            }

            if ($between) {
                return $type;
            }
        }
    }
}