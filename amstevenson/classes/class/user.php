<?php

class User
{

    private $db;

    /*
     * As soon as the class is fun, this method is called so that all methods
     * will have access to the database
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /*
     * Check if the user is logged in. This looks for a session called 'logged in'.
     * If it is set and true, this indicates that the user is logged in, else false.
     */
    public function is_logged_in()
    {
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            return true;
        } else return false;
    }

    /*
     * Get the privileges of the user
     */
    public function is_user_admin(){
        if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
            return true;
        } else return false;
    }

    public function create_hash($value)
    {
        return $hash = crypt($value, '$2a$12'.substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22));
    }

    /*
     * This is used to get the hashed password from the database.
     */
    private function get_user_hash($username){

        try {

            $stmt = $this->db->prepare('SELECT password FROM blog_members WHERE username = :username');
            $stmt->execute(array('username' => $username));

            $row = $stmt->fetch();
            return $row['password'];

        } catch(PDOException $e) {
            echo '<p class="error">'.$e->getMessage().'</p>';
            return false;
        }
    }

    /*
     * To verify the hash, we pass the password from the database, and the hashed
     * value and ensure that they are equal to one another.
     */
    private function password_verify($password, $hashed)
    {
        return $hashed == crypt($password, $hashed);
    }

    /*
     * Login to the administrative site of the blogging section for the website (if the user is
     * an admin), otherwise the user can only add new blogs
     */
    public function login($username,$password){

        $hashed = $this->get_user_hash($username);

        // Get the role of the user
        $role = "user";

        try {

            $stmt = $this->db->prepare('SELECT role FROM blog_members WHERE username = :username');
            $stmt->execute(array('username' => $username));

            $row = $stmt->fetch();
            $role = $row['role'];

        } catch(PDOException $e) {
            echo '<p class="error">'.$e->getMessage().'</p>';
        }

        if($this->password_verify($password,$hashed) == 1){

            // After we have verified the username and password, reset the
            // session_id in order to protect against a fixation attack.
            session_regenerate_id();

            // Store session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $role;
            $_SESSION['username'] = $username;
            return true;
        }
        else return false;
    }

    /*
     * Log out and destroy the session and associated variables.
     */
    public function logout(){
        session_destroy();
    }

}



