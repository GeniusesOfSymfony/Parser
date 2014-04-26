<?php
namespace Gos\Component\Parser;

use Behat\Transliterator\Transliterator;

class Parser
{
    /**
     * @param $string
     * Camelize a string
     * @return string
     */
    public static function camelize($string)
    {
        /**
         * This is a part of symfony2 | We duplicate it to avoid symfony2 dependency, if he is split, we will use it
         * as dependency like Doctrine::Urlize with Behat
         */
        return strtr(ucwords(strtr($string, array('_' => ' ', '.' => '_ ', '\\' => '_ '))), array(' ' => ''));
    }

    /**
     * @param $string
     * Transliterate string to valide slug
     * @return string
     */
    public static function urlize($string)
    {
        return Transliterator::urlize($string);
    }

    /**
     * @param $string
     * Split string with _
     * @return string
     */
    public static function underscore($string, $convertSpace = false)
    {
        $lookingFor = array(
            '/([A-Z]+)([A-Z][a-z])/',
            '/([a-z\d])([A-Z])/',
        );

        $by = array(
            '\\1_\\2',
            '\\1_\\2'
        );

        if(true === $convertSpace){
            $lookingFor[] = '/\s+/';
            $by[] = '_';
        }

        return strtolower(preg_replace($lookingFor, $by, strtr($string, '_', '.')));
    }

    /**
     * @param $string
     * Delete string accent
     * @return string
     */
    public static function unaccent($string)
    {
        return Transliterator::unaccent($string);
    }
} 