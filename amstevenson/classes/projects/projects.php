<?php 
class Projects{

	private $db;
	public function __construct($database) {
	     $this->db = $database;
	}

    // Get all of the projects from within the database
	function get_projects(){

	    $query = $this->db->prepare("SELECT * FROM `Projects` ORDER BY `project_id` ASC");
	
        try{
            $query->execute();
            }
        catch (PDOEXCEPTION $e) {
            die($e->getMessage());
            }
        return $query->fetchALL();
	}

    // Get one project by referencing the project name; feels more easy to remember than...for example, a number
    // and I don't think I'd have more than one project with the same name.
    function get_one_project($project_name){

        $query = $this->db->prepare("SELECT * FROM `Projects` WHERE `project_name` = '$project_name'");

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
