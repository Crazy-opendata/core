<?php

namespace CrazyOpendata\Core\Export;

use CrazyOpendata\Core\Config;
use CrazyOpendata\Core\Export;

class Mysql extends Export
{

    public $format = "sql";

    public function exportRaw($country)
    {
        $mysql_cmd   = "/usr/bin/mysqldump "
            ." -u".$this->config->mysqlUser
            ." -p".$this->config->mysqlPass
            ." --extended-insert=false --skip-dump-date --skip-add-drop-table ";

        $where_sql = "";
        $where_option="";
        if ($this->options) {
            $where_sql = "where $this->options";
            $where_option = "--where '$this->options'";
        }
        $sed = "sed 's/LOCK TABLES /DELETE FROM \`".$this->config->mysqlTable."\` $where_sql; LOCK TABLES /'";
        $sed .= "| sed 's/CREATE TABLE /CREATE TABLE IF NOT EXISTS /'";

        exec("$mysql_cmd ".$this->config->mysqlBase." ".$this->config->mysqlTable." $where_option | $sed > $this->filename");


    }
}
