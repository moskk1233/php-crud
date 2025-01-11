<?php

namespace Framework\Database;

use PDO;

class PDOConnection
{
  public static function getConnection(): PDO
  {
    $server = "mysql";
    $username = "moskuza";
    $password = "moskuza";
    $dbname = "my_database";

    $pdo = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
  }
}
