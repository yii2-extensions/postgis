<?php

namespace Yii2\Extension\Postgis\Helpers;

use yii\helpers\Json;

/**
 * Class GeoJsonHelper
 * Helper to convert coordinates to GeoJson and GeoJson to coordinates
 * @package Yii2\Extension\Postgis
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class GeoJsonHelper
{

    /**
     * Convert coordinates to GeoJson
     * @param string $type geometry type
     * @param array $coordinates array of coordinates
     * @param int $srid SRID
     * @return string json
     */
    public static function toGeoJson($type, $coordinates, $srid = 4326)
    {

        $geoJson = [
            'type' => $type,
            'coordinates' => $coordinates,
        ];

        if (!is_null($srid)) {

            $geoJson['crs'] = [
                'type' => 'name',
                'properties' => ['name' => "EPSG:$srid"],
            ];
        }

        return Json::encode($geoJson);
    }

    /**
     * Convert coordinates to Geometry Expression
     * @param string $type geometry type
     * @param array $coordinates array of coordinates
     * @param int $srid SRID
     * @return string
     */
    public static function toGeometry($type, $coordinates, $srid = 4326)
    {

        $geoJson = self::toGeoJson($type, $coordinates, $srid);

        return "ST_GeomFromGeoJSON('$geoJson')";
    }

    /**
     * Convert GeoJson to coordinates
     * @param string $geoJson GeoJson
     * @return mixed
     */
    public static function toArray($geoJson)
    {

        $geoJson = Json::decode($geoJson);

        return $geoJson['coordinates'];
    }
}
