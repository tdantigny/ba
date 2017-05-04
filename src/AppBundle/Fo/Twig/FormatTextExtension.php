<?php

namespace AppBundle\Fo\Twig;

/**
 * Class FormatTextExtension
 * @package AppBundle\Fo\Twig
 */
class FormatTextExtension extends \Twig_Extension
{
    /**
     * FormatTextExtension constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('FormatText', array($this, 'addBold', 'addSouligne')),
        );
    }

    /**
     * Get the pourcentage of recommandation
     *
     * @param int $yearBookId
     * @return float
     */
    public function addBold(string $text)
    {
        $explode = explode('*', $text);
        $newText = '';
        $etat = 0;

        foreach ($explode as $element) {
            if (empty($element) && $etat !== 2) {
                $etat = 1;
            }

            if ($etat === 1) {
                $newText .= '<strong>' . $element;
                $etat = 2;
            }
            elseif ($etat === 2) {
                $newText .= $element . '</strong>';
                $etat = 0;
            }
            else {
                $newText .= $element;
            }
        }

        return $newText;
    }

    /**
     * Get the pourcentage of recommandation
     *
     * @param int $yearBookId
     * @return float
     */
    public function addSouligne(string $text)
    {
        return $text;
    }
}