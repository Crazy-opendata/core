<?php

namespace CrazyOpendata\Core;

use CrazyOpendata\Core\Export\CSV;
use CrazyOpendata\Core\Export\GeoJSON;
use CrazyOpendata\Core\Export\JSON;
use CrazyOpendata\Core\Export\Mysql;
use CrazyOpendata\Core\Export\KML;

abstract class Export
{

    public $config;
    public $format;
    public $options = null;
    public $filename;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getDir()
    {
        return $this->config->dataDir."/".$this->format;
    }

    public function createDir()
    {
        $dir = $this->getDir();
        if (!is_dir($dir)) {
            mkdir($dir, null, true);
        }
    }

    public function getFilename($name)
    {
        return $this->getDir()."/".$name.".".$this->format;

    }

    public function export($lines, $name)
    {
        $this->createDir();
        $this->filename = $this->getFilename($name);

        echo "Creating $this->filename\n";
        $this->exportRaw($lines);
    }

    public static function exportAll($config, $exportName)
    {
        $dbh = $config->getDB();
        $sth = $dbh->prepare("SELECT * FROM ".$config->mysqlTable);
        $sth->execute();
        $liste = $sth->fetchAll(\PDO::FETCH_ASSOC);


        $csv = new CSV($config);
        $csv->export($liste, $exportName);

        $json = new JSON($config);
        $json->export($liste, $exportName);

        $geojson = new GeoJSON($config);
        $geojson->export($liste, $exportName);

        $mysql = new Mysql($config);
        $mysql->export($liste, $exportName);

        $kml = new KML($config);
        $kml->export($liste, $exportName);
    }
}
