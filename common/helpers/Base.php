<?php
/**
 * Base helper methods
 *
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace common\helpers;

use Yii;

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

    public static function getCurrentBalance($format = true)
    {
        $balance = Yii::$app->user->identity->getBalance();
        if($format)
            return static::formatMoney( $balance );
        else
            return $balance;
    }

    public static function getCurrency()
    {
        return Yii::$app->params['defaultCurrency'];
    }

    public static function formatMoney($num, $currency = false, $withoutCurrency = false)
    {
        $money = number_format($num, 2, '.', ' ');

        if($withoutCurrency)
            return $money;

        if(!$currency)
            $currency = static::getCurrency();

        return static::formatCurrency($money, $currency);
    }

    public static function formatCurrency($money, $currency)
    {
        $after = true;
        $symb = '';
        switch($currency)
        {
            case 'usd':
                $symb = '$';
                break;
            case 'rub':
                $symb = 'р.';
                break;
            case 'cny':
                $symb = '&yen;';
                $after = false;
                break;
        }
        if($after)
            return $money.' '.$symb;
        else
            return $symb.' '.$money;
    }
}