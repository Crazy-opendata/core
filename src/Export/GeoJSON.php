<?php

namespace CrazyOpendata\Core\Export;

use CrazyOpendata\Core\Export;

class GeoJSON extends Export
{

    public $format = "geojson";

    public function exportRaw($lines)
    {

        $collection = array(
            "type" => "FeatureCollection",
            "features" => array(),
        );

        foreach ($lines as $line) {
            $collection['features'][] = array(
                "type" => "Feature",
                "geometry" => array(
                    "type" => "Point",
                    "coordinates" => array_reverse(explode(',', $line['coordonnees'])),
                    "properties" => $line,
                )
            );
        }

        file_put_contents($this->filename, json_encode($collection, JSON_PRETTY_PRINT));
    }
}
