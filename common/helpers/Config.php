<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\common\helpers;

use yashop\common\models\Setting;
use Yii;
use yii\db\Query;

class Config
{
    /**
     * @var array Config data
     */
    protected static $cachedData;

    /**
     * @var string Key for cache identifying
     */
    public static $cacheKey = 'config';

    /**
     * @var int Period for cache. 3 hours
     */
    public static $cachePeriod = 10800;

    /**
     * Get config param by key
     * @param $key
     * @return mixed|null
     */
    public static function get($key)
    {
        $data = self::getCachedData();

        return isset($data[$key]) ? $data[$key] : null;
    }

    /**
     * Returns array with config data
     * @return array
     */
    protected static function getCachedData()
    {
        if(!self::$cachedData) {
            self::$cachedData = self::loadDataFromCache();
        }
        return self::$cachedData;
    }

    /**
     * Load config data from cache
     * @return array
     */
    protected static function loadDataFromCache()
    {
        $cache = Yii::$app->cache->get(self::$cacheKey);
        if($cache)
            return $cache;

        $data = self::loadDataFromDB();
        Yii::$app->cache->set(self::$cacheKey, $data, self::$cachePeriod);

        return $data;
    }

    /**
     * Load config data from database
     * @return array
     */
    protected static function loadDataFromDB()
    {
        $data = (new Query())->select('*')->from(Setting::tableName())->all();
        $res = [];
        foreach($data as $item)
        {
            $key = $item['name'];
            if(!is_null($item['value_string']))
                $res[$key] = $item['value_string'];

            if(!is_null($item['value_integer']))
                $res[$key] = $item['value_integer'];

            if(!is_null($item['value_float']))
                $res[$key] = $item['value_float'];
        }

        return $res;
    }
}