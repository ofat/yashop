<?php
/**
 * Base helper methods
 *
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace common\helpers;

class Base
{
    /**
     * @var array Base date formats
     */
    private static $_dateFormats = [
        'date' => 'd-m-Y',
        'datetime' => 'd-m-Y H:i',
        'datetimesec' => 'd-m-Y H:i:s'
    ];

    /**
     * Formating date to needed format
     *
     * @param integer $timestamp
     * @param string $format
     * @return bool|string
     */
    public static function formatDate($timestamp, $format = 'datetime')
    {
        return date(self::$_dateFormats[$format], $timestamp);
    }
}