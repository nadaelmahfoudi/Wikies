<?php

require_once 'Model.php';

class UserModel extends Model
{

    private string $fullName;
    private string $email;
    private string $password;
    private string $role;

    private int $id;
    public function __construct()
    {
        parent::__construct();
    }


    public function getFullName()
    {
        return $this->fullName;
    }
    public function setFullName($FullName)
    {
        $this->fullName = $FullName;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setRoleId($role)
    {
        $this->role = $role;
    }
    public function getRole()
    {
        return $this->role;
    }
    public static function emailExist($email)
    {
        return self::selectRecords('user', '*', 'email = ' . $email);
    }

    public function registerUser()
    {
        if (!isset($this->role)) {
             $this->role = 'auteur';
        }
        if (isset($this->email)) {
            $data = array(
                'email' => $this->email,
                'name' => $this->fullName,
                'password' => $this->password,
                'role' => $this->role
            );
            return $this->insertRecord('user', $data);
        } else {
            return false;
        }
    }
    

    public function selectUser($email)
    {
        return $this->selectRecords('user', '*', 'email = ' .'"'.$email.'"');
    }

    public function getWikiesByUserId($userId)
{
    return $this->selectRecords('wiki', '*', 'user_id = ' . $userId);
}

public function fetchAllUsers() {
    $stmt = $this->pdo->query('SELECT * FROM user');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    
}
