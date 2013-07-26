<?php

require_once(ROOT_DIR.'/'.CLASS_DIR.'/'.DB_DIR.'/config.php');

class MySQL_Connection{
	private $host;
	private $username;
	private $pass;
	private $database;
	private $connection=null;
	private $errors=array();
	private $result;
	private $query;
	private $numResults;
	private $fetchedResults=array();
	
	function __construct(){
		$this->host=HOST;
		$this->username=USERNAME;
		$this->pass=PASSWORD;
		$this->database=MySQL_DB;
	}
	/*------------------------*
	 *
	 * Handle connections
	 *
	 *------------------------*/
	public function connect(){
		$this->connection=mysql_connect($this->host,$this->username,$this->pass) or $this->setErrors('could not connect to host, due to '.mysql_error());	
		mysql_select_db($this->database) or $this->setErrors('could not select DB, due to '.mysql_error());
		mysql_query('SET NAMES UTF8');
	}
	public function disconnect(){
			mysql_close($this->connection) or $this->setErrors('couldn\'t not close connection due to '.mysql_error());
	}
	/*------------------------*
	 *
	 * Handle queries
	 *
	 *------------------------*/
	public function select($table,$rows='*',$where=null,$order=null,$limit=null){
		$query='SELECT '.$rows.' FROM '.$table;
		if(!is_null($where))
			$query.= ' WHERE '.$where;
		if($order != null)
        	$query.= ' ORDER BY '.$order;
		if($limit != null)
        	$query.= ' LIMIT '.$limit;
			$this->query=$query;
	}
	
	
	public function insert($table, $columns,$values){
		$query='INSERT INTO '.$table.' (';
		for($i=0;$i<sizeof($columns);$i++){
			if($i==(sizeof($columns)-1)){
				$query.=$columns[$i];
			}else{
				$query.=$columns[$i].",";
			}
		}
			$query.=') VALUES(';
			for($i=0;$i<sizeof($values);$i++){
				if($i==(sizeof($values)-1)){
					$query.="'".$values[$i]."'";
				}else{
					$query.="'".$values[$i]."',";
				}
			}
			$query.=')';
			$this->query=$query;
	}
	
	public function update($table, $columns,$values,$where=null,$limit=null){
		$query='UPDATE '.$table.' SET ';
		for($i=0;$i<sizeof($columns);$i++){
				if($i==(sizeof($columns)-1)){
					$query.=$columns[$i]."='".$values[$i]."'";
				}else{
					$query.=$columns[$i]."='".$values[$i]."',";
				}
			}
		if(!is_null($where))
			$query.=' WHERE '.$where;
		if(!is_null($limit))
			$query.=' LIMIT '.$limit;
		$this->query=$query;
	}
	public function delete($table,$column,$value){
		$query='DELETE FROM '.$table.' WHERE '.$column.'='.$value;
		$this->query=$query;
	}
	public function query($szQuery){
		if($return){
			$this->query=$szQuery;
			$this->execute($szQuery);			
		}else{
			$this->query=$szQuery;
			$this->execute($szQuery);
		}
	}
	
	
	public function execute(){
		$this->result=mysql_query($this->query) or $this->setErrors('couldn\'t execute query due to'.mysql_error().' . Query was "'.$this->query.'"');
	}
	
	public function numResults(){
		$this->numResults=mysql_num_rows($this->result) or $this->setErrors('couldn\'t numResults due to'.mysql_error().' . Query was "'.$this->query.'"');
	}
	public function fetchResults(){
		while($arr=mysql_fetch_array($this->result))
			array_push($this->fetchedResults,$arr);	
	}

	/*------------------------
	 *
	 *	GETTERS SETTERS
	 *
	/*------------------------*/
	public function getErrors(){
		return $this->errors;
	}
	
	public function setErrors($error){
		array_push($this->errors,$error);
	}
	
	public function getResult(){
		return $this->result;
	}
	
	public function getnumResults(){
		return $this->numResults;
	}
	
	public function setfetchedResults(){
		$this->fetchedResults=array();
	}
	
	public function getfetchedResults(){
		return $this->fetchedResults;
	}
	
	
	
	
}
	
?>