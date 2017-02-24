<?php

namespace AppBundle\Core\Services;

use AppBundle\Core\Exception\CustomException;
use Symfony\Component\DomCrawler\Crawler;
use AppBundle\Core\Model\Horoscope as HoroscopeModel;
use Snc\RedisBundle\Client\Phpredis\Client as Redis;

/**
 * Class Horoscope
 * @package AppBundle\Core\Services
 */
class Horoscope
{
    const LIFETIME = 86400;
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
     * @var Redis
     */
    private $redis;

    /**
     * Horoscope constructor.
     * @param array $urlsHorosocope
     * @param Redis $redis
     */
    public function __construct(array $urlsHorosocope, $redis)
    {
        $this->urlsHorosocope = $urlsHorosocope;
        $this->redis = $redis;
    }

    /**
     * Get all horoscope model
     * @param string $type
     * @throws CustomException
     * @return HoroscopeModel
     */
    public function getByType(string $type)
    {
        $now = new \DateTime();
        $cleCache = $now->format('Y-m-d').'_horoscope_'.$type;
        if ($this->redis->exists($cleCache)) {
            return unserialize($this->redis->get($cleCache));
        }

        try {
            $urlHoroscope = $this->getTypeFrenchToEnglish($type);
            $modelHoroscope = $this->getXml($urlHoroscope, $type);
        } catch (CustomException $customException) {
            throw new CustomException('Impossible de récupérer les horoscopes : code '.$customException->getCode().'.', -1);
        }

        $this->redis->setEx($cleCache, self::LIFETIME, serialize($modelHoroscope));

        return $modelHoroscope;
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
     * Convert type name in english
     *
     * @param string $type
     * @return string
     * @throws CustomException
     */
    private function getTypeFrenchToEnglish(string $type)
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
     * Construct the horscope model from the xml content
     *
     * @param array $content
     * @throws CustomException
     * @return HoroscopeModel
     */
    private function construcModel(array $content)
    {
        $horoscopeModel = new HoroscopeModel();

        if (!isset($content[0])) {
            throw new CustomException('XML not valid', 3);
        }

        if (!isset($content[0][0]) || !isset($content[0][3]) || !isset($content[0][4]) || !isset($content[0][6])) {
            throw new CustomException('XML not valid', 4);
        }

        $horoscopeModel->setTitle($content[0][0]);
        $horoscopeModel->setContent($content[0][3]);
        $horoscopeModel->setDate(new \DateTime($content[0][4]));
        $horoscopeModel->setType($content[0][6]);

        return $horoscopeModel;
    }

    /**
     * Get the xml for the horosocope
     *
     * @param string $urlHoroscope
     * @param string $typeHorosocpe
     * @throws CustomException
     * @return HoroscopeModel
     */
    private function getXml(string $urlHoroscope, string $typeHorosocpe)
    {
        $xmlDoc = new \DOMDocument();
        $xmlDoc->load($urlHoroscope);

        if (false === $xmlDoc) {
            throw new CustomException('Impossible de récupérer l\'horoscope'.$typeHorosocpe.'.', 1);
        }

        $crawler = new Crawler($xmlDoc);

        if (empty($crawler)) {
            throw new CustomException('XML not valid', 2);
        }

        try {
            $content = $crawler->filter('item')->each(function (Crawler $element) {
                return $element->children()->each(function (Crawler $underElement) {
                    return $underElement->text();
                });
            });
        } catch (\RuntimeException $runtimeException) {
            throw new CustomException('XML not valid', 2);
        }

        $content[0][] = $typeHorosocpe;

        return $this->construcModel($content);
    }
}
