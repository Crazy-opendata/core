<?php

namespace CrazyOpendata\Core\Export;

use CrazyOpendata\Core\Config;
use CrazyOpendata\Core\Export;

class KML extends Export
{

    public $format = "kml";

    public function exportRaw($lines)
    {

        $content = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $content .= '<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">'."\n";
        $content .= '<Document>'."\n";

        foreach ($lines as $line) {

            $description = "";
            $name = "";
            foreach ($line as $key => $value) {
                $description = "$key : $value<br/>\n";
                if (preg_match("/^(name|title)/", $key)) {
                    $name = $value;
                }
            }


            $content .= "   <Placemark>\n";
            $content .= "       <name>".$name."</name>\n";
            $content .= "       <description>$description</description>\n";
            $content .= "       <Point>\n";
            $content .= "           <coordinates>".implode(",", array_reverse(explode(",", $line["coordonnees"])))."</coordinates>\n";
            $content .= "       </Point>\n";
            $content .= "   </Placemark>\n";
        };

        $content .= "</Document>\n";
        $content .= "</kml>\n";
    
    
        file_put_contents($this->filename, $content);
    }
}
