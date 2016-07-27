<?php

namespace CrazyOpendata\Core\Export;

use CrazyOpendata\Core\Export;

class JSON extends Export
{

    public $format = "json";

    public function exportRaw($lines)
    {
        file_put_contents($this->filename, json_encode($lines));
    }
}
