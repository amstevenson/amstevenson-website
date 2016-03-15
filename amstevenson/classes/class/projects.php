<?php 
class Projects{

	private $db;
	public function __construct($database) {
	     $this->db = $database;
	}

    // Get all of the class from within the database
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

        $query = $this->db->prepare("SELECT * FROM `Projects` WHERE `project_name` = :project_name");

        try{
            $query->execute(array(':project_name' => $project_name));
        }
        catch (PDOEXCEPTION $e) {
            die($e->getMessage());
        }
        return $query->fetchALL();
    }

    // Get all of the categories for the projects
    function get_project_categories()
    {
        $query = $this->db->prepare("SELECT * FROM `project_cats` ORDER BY `projCatTitle` ASC");

        try{
            $query->execute();
        }
        catch (PDOEXCEPTION $e) {
            die($e->getMessage());
        }
        return $query->fetchALL();
    }

    // Get one category, with reference to an ID
    function get_project_category($category_id)
    {
        $query = $this->db->prepare("SELECT * FROM project_cats WHERE projCatID = :category_id ORDER BY projCatTitle ASC");

        try{
            $query->execute(array(':category_id' => $category_id));
        }
        catch (PDOEXCEPTION $e) {
            die($e->getMessage());
        }
        return $query->fetchALL();
    }

    // Shuffle all projects; randomise.
    function array_shuffle(&$array) {
        if (shuffle($array)) {
            return $array;
        } else {
            return FALSE;
        }
    }

    function array_put_to_position(&$array, $object, $position, $name = null)
    {
        $count = 0;
        $return = array();

        foreach ($array as $k => $v)
        {
            // insert new object
            if ($count == $position)
            {
                if (!$name) $name = $count;
                $return[$name] = $object;
                $inserted = true;
            }
            // insert old object
            $return[$k] = $v;
            $count++;
        }

        if (!$name) $name = $count;
        if (!$inserted) $return[$name];

        $array = $return;
        return $array;
    }
}
