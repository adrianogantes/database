<?php

namespace Db;

class Database
{
  private $DB;
  protected $sql;
  protected $prepared;
  protected $index;
  protected $tableJoin;
  protected $tbName;
  protected $post;
  public $data;
  protected $error;

  public function __construct($dbType)
  {

    $this->DB = Connect::open(LIB . 'db' . DIRECTORY_SEPARATOR . $dbType);

  }

  public function query($sql)
  {

    $this->prepared = $this->DB->prepare($sql);

  }

  public function exec($payload = null) {

    if ($payload) {

      $vals = array_values(get_object_vars($payload));

    } else {

      $vals = array();

    }

    if ($this->prepared->execute($vals)) {

      $this->data = $this->prepared->fetchAll(\PDO::FETCH_OBJ);

      $this->close();

    } else {

      $this->error = $this->prepared->errorInfo();

    }

  }

  function close() {
    Connect::close();
  }

  function getSql() {
    return $this->sql;
  }

}
