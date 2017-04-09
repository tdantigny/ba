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

    /**
     * @var HoroscopeDictionnary
     */
    private $horoscopeDictionnary;

    /**
     * @var Redis
     */
    private $redis;

    /**
     * Horoscope constructor.
     * @param HoroscopeDictionnary $horoscopeDictionnary
     * @param Redis                $redis
     */
    public function __construct(HoroscopeDictionnary $horoscopeDictionnary, Redis $redis)
    {
        $this->horoscopeDictionnary = $horoscopeDictionnary;
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
            $urlHoroscope = $this->horoscopeDictionnary->getUrlFromFrenchType($type);
            $modelHoroscope = $this->getXml($urlHoroscope, $type);
        } catch (CustomException $customException) {
            throw new CustomException('Impossible de récupérer les horoscopes : code '.$customException->getCode().'.', -1);
        }

        $this->redis->setEx($cleCache, self::LIFETIME, serialize($modelHoroscope));

        return $modelHoroscope;
    }

    /**
     * Get a random horosocope
     *
     * @return HoroscopeModel
     */
    public function getRandomOne()
    {
        $allType = $this->horoscopeDictionnary->getAllType();
        $randomKeyType = rand(0, 11);
        $frenchType = $this->horoscopeDictionnary->getTypeEnglishToFrench($allType[$randomKeyType]);

        return $this->getByType($frenchType);
    }

    /**
     * Get the daily horoscope to the current user
     *
     * @param \DateTime $birthDate
     * @return HoroscopeModel
     */
    public function getByBirthDate(\DateTime $birthDate)
    {
        $type = $this->horoscopeDictionnary->getTypeByDate($birthDate);

        $frenchType = $this->horoscopeDictionnary->getTypeEnglishToFrench($type);

        return $this->getByType($frenchType);
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
        $horoscopeModel->setContent($this->cleanContent($content[0][3]));
        $horoscopeModel->setDate(new \DateTime($content[0][4]));
        $horoscopeModel->setType($content[0][6]);
        $horoscopeModel->setPrimaryPicture(
            $this->horoscopeDictionnary->getTypeFrenchToEnglish($content[0][6]).'_primary.png'
        );
        $horoscopeModel->setSecondaryPicture(
            $this->horoscopeDictionnary->getTypeFrenchToEnglish($content[0][6]).'_secondary.png'
        );

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

    /**
     *
     *
     * @param string $content
     * @return string
     */
    private function cleanContent(string $content)
    {
        $cleanContent = preg_replace('#\\n*#', '', $content);
        $cleanContent = preg_replace('#^<br\/>#', '', $cleanContent);
        $cleanContent = preg_replace('#<center><a.*<\/center>#', '', $cleanContent);
        $cleanContent = preg_replace('#<center>.*<\/center>#', '', $cleanContent);
        $cleanContent = preg_replace('#^<br><br>#', '', $cleanContent);
        $explodeContent = explode('Horoscope', $cleanContent);

        foreach ($explodeContent as $key => $truncateContent) {
            if (false !== strpos($truncateContent, 'Argent')
                || false !== strpos($truncateContent, 'Vie sociale')
                || false !== strpos($truncateContent, 'Famille')
                || false !== strpos($truncateContent, 'Nombre de chance')
                || false !== strpos($truncateContent, 'Citation du jour')
                || false !== strpos($truncateContent, 'Clin d\'oeil')
            ) {
                unset($explodeContent[$key]);
            }
        }

        return implode('Horoscope', $explodeContent);
    }
}
