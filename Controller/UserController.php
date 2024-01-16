<?php 
session_start();
require_once 'Controller.php';
require_once 'Model/UserModel.php';

class UserController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function getAllUsers() {
        
    {
        $user = new UserModel();
        $users = $user->fetchAllUsers();
        return $users;
    }
    }

    
    

}  
function test_input($data) {
    if ($data === null) {
        return null;
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}  