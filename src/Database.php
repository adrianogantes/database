<?php

namespace Db;

class Database
{
  private $DB;
  private $sql;
  private $prepared;
  private $error;
  public $data;

  public function __construct($path)
  {

    $this->DB = Conn::open($path);

  }

  public function query($sql)
  {

    $this->sql = $sql;
 
    $this->prepared = $this->DB->prepare($sql);

  }

  public function exec(Array | Object $payload = null) {

    if ($payload) {

      if (is_array($payload)) $vals = array_values($payload);
      else $vals = array_values(get_object_vars($payload));

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
    Conn::close();
  }

  function getSql() {
    return $this->sql;
  }

}
