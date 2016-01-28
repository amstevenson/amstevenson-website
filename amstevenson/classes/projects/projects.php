<?php 
class Projects{

	private $db;
	public function __construct($database) {
	     $this->db = $database;
	}


	function get_tutorials(){
	$query = $this->db->prepare("SELECT * FROM `Projects` ORDER BY `project_id` ASC");
	
	try{
		$query->execute();
		}
	catch (PDOEXCEPTION $e) {
		die($e->getMessage());
		}
	return $query->fetchALL();
	}

    function array_shuffle(&$array) {
        if (shuffle($array)) {
            return $array;
        } else {
            return FALSE;
        }
    }
}
