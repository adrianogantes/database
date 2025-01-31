<?php

namespace Db;

class Conn
{
    static $conn;

    private function __construct() {}

    static function open($filename)
    {

        $file = "{$filename}.ini";

        if (file_exists($file)) {

            $ini = parse_ini_file($file);

        } else {

            throw new \Exception("Arquivo '$file' nao encontrado.");

        }

        $user = isset($ini['user']) ? $ini['user'] : NULL;
        $pass = isset($ini['pass']) ? $ini['pass'] : NULL;
        $name = isset($ini['name']) ? $ini['name'] : NULL;
        $host = isset($ini['host']) ? $ini['host'] : NULL;
        $port = isset($ini['port']) ? $ini['port'] : NULL;

        $port = $port ? $port : '3306';

        self::$conn = new \PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));

        self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return self::$conn;
    }

    static function close() {
        self::$conn = null;
    }
}
