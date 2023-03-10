<?php
class db
{

  // private $dbhost = 'dev.cpe.rmuti.ac.th/ktec/';
  private $dbhost = 'localhost';
  private $dbuser = 'root';
  private $dbpass = 'root123456';
  private $dbname = 'ktec';
  
  // private $dbhost = 'localhost';
  // private $dbuser = 'id20167855_ktecdatabase';
  // private $dbpass = '[E<^N{GByawR<1ID';
  // private $dbname = 'id20167855_ktec';

  // private $dbhost = 'dev.cpe.rmuti.ac.th';
  // private $dbuser = 'ktec';
  // private $dbpass = 'Ktec@CPE';
  // private $dbname = 'ktec';

  public function connect()
  {
    // https://www.php.net/manual/en/pdo.connections.php
    $prepare_conn_str = "mysql:host=$this->dbhost;dbname=$this->dbname";
    $dbConn = new PDO($prepare_conn_str, $this->dbuser, $this->dbpass);
    $dbConn->exec("set names utf8");
    // https://www.php.net/manual/en/pdo.setattribute.php
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // return the database connection back
    return $dbConn;
  }
}
?>