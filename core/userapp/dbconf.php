<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class dbconf extends db {
    function __construct() {
        $this->dbhost = "sql.itcn.dk";
	    $this->dbuser = "tobi4882.SKOLE";
        $this->dbpassword = "52b1TbWy5P";
        $this->dbname = "tobi48822.SKOLE";
        $db = parent::_connect();
    }
}