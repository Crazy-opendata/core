<?php

namespace CrazyOpendata\Core;

class Config
{

    public $mysqlUser;
    public $mysqlPass;
    public $mysqlBase;
    public $mysqlHost;
    public $mysqlTable;
    public $mysqlPort;
    public $dataDir;

    public function __construct($user, $pass, $base, $host, $table, $dir = "data", $port = 3306)
    {
        $this->mysqlUser  = $user;
        $this->mysqlPass  = $pass;
        $this->mysqlBase  = $base;
        $this->mysqlHost  = $host;
        $this->mysqlTable = $table;
        $this->mysqlPort  = $port;
        $this->dataDir    = $dir;
    }

    public function getDB()
    {
        $dbh = null;
        try {
            $dbh = new \PDO(
                "mysql:host=".$this->mysqlHost
                .";port=".$this->mysqlPort
                .";dbname=".$this->mysqlBase,
                $this->mysqlUser,
                $this->mysqlPass,
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
        } catch (\Exception $e) {
            echo "Unable to connect: " . $e->getMessage() ."<p>";
        }
        return $dbh;

    }

}
