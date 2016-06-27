<?php

/**
 * @TODO phpDoc
 */
class Configurations extends App{
  
  // Database Connection
  private $__db = false;
  
  // Nome da coleção
  private $__collectionName = 'Configurations';
  
  /**
   * tarefa - phpDoc
   */
  function __construct() {
    
    // Database connection cursor
    $this->__db = $_SESSION['__db'];
    $tmp = $this->__collectionName;
    $this->collection = $this->__db->$tmp;
    parent::__construct();
  }


  public function Collection(){
    return $this->collection;
  }  
}
