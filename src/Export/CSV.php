<?php

namespace CrazyOpendata\Core\Export;

use CrazyOpendata\Core\Config;
use CrazyOpendata\Core\Export;

class CSV extends Export
{

    public $format = "csv";

    public function exportRaw($lines)
    {

        $fcsv = fopen($this->filename, "w+");

        foreach ($lines as $i => $line) {
            if ($i == 0) {
                fputcsv($fcsv, array_keys($line), ";", '"');
            }
            fputcsv($fcsv, $line, ";", '"');
        }

        fclose($fcsv);
    }
}
