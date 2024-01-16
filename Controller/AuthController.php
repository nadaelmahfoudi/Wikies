<?php 
session_start();
include 'Controller.php';
include '../Model/UserModel.php';

class AuthController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function indexAuth()
    {
        $this->view('sign-up');
    }

    public function login()
    {
        $this->view('login');
    }

    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            extract($_POST);
            $userlog = $this->user->selectUser($email);
    
            if (!empty($userlog)) { // Check if $userlog is not empty 
                $firstUser = $userlog[0]; // Get the first user from the array
    
                if (password_verify($password, $firstUser['password'])) {
    
                    $_SESSION['idUser'] = $firstUser['id'];
                    $_SESSION['roleUser'] = $firstUser['role'];
                    $_SESSION['emailUser'] = $firstUser['email'];
                    $_SESSION['nameUser'] = $firstUser["name"];
    
                    if ($_SESSION['roleUser'] == 'admin') {
                        header("location: Dashboard.php" );
                        exit(); 
                    }
                    if ($_SESSION['roleUser'] == 'auteur') {
                        header("location: index.php");
                        exit(); // finish the script after redirection
                    }
                }
            }
        }
    }
    

    

    public function registration()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $_POST['submit'] == 'submit') {
            $fullName = isset($_POST['name']) ? test_input($_POST['name']) : '';
            $email = isset($_POST['email']) ? test_input($_POST['email']) : '';
            $password = isset($_POST['password']) ? test_input($_POST['password']) : '';
    
            // Utilisez les setters pour définir les valeurs dans votre modèle
            $this->user->setFullName($fullName);
            $this->user->setEmail($email);
            $this->user->setPassword(password_hash($password, PASSWORD_DEFAULT));
    
            if ($this->user->registerUser()) {
                $_SESSION['emailUser'] = $this->user->getEmail();
                header("location: login.php");
                exit(); // Ajout de l'instruction exit après la redirection
            } else {
                echo "errors";
            }
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