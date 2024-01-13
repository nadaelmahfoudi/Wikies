<?php

// use PDO;
// use PDOException;
require_once "Database.php";
class Model 
{

    public $pdo; 
    public function __construct()
    {
        $instance = Database::getInstance();
        $this->pdo = $instance->getConnection();
    }

    public function getElementById(string $table, int $id)
    {
        try {
            // Use prepared statements to prevent SQL injection
            $sql = "SELECT * FROM $table WHERE id = $id";

            // Prepare the SQL query
            $stmt = $this->pdo->prepare($sql);

            // Execute the prepared statement with any bound parameters
            $stmt->execute();

            // Fetch the result set as an associative array
            $result = $stmt->fetchAll( PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            return null;
        }
    }
    // use connection;
    public function selectRecords(string $table, string $columns = "*", string $where = null)
    {
        try {
            // Use prepared statements to prevent SQL injection
            $sql = "SELECT $columns FROM $table";

            if ($where !== null) {
                $sql .= " WHERE $where";
            }

            // Prepare the SQL query
            $stmt = $this->pdo->prepare($sql);

            // Execute the prepared statement with any bound parameters
            $stmt->execute();

            // Fetch the result set as an associative array
            $result = $stmt->fetchAll( PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            return null;
        }
    }
    public function insertRecord(string $table, array $data, string $where = null)
    {
        // Use prepared statements to prevent SQL injection
        $columns = implode(', ', array_keys($data));

        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        try {
            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

            if ($where !== null) {
                $sql .= " WHERE $where";
            }

            $stmt = $this->pdo->prepare($sql);


            // Bind parameters to the prepared statement by reference
            $i = 1;
            foreach ($data as $key => &$value) {
                $stmt->bindParam($i, $value);
                $i++;
            }
            $stmt->execute();
            return true;
            
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateRecord($table, $data, $id)
    {
        // Use prepared statements to prevent SQL injection
        $args = array();

        foreach ($data as $key => $value) {
            $args[] = "$key = ?";
        }
        try {
            $sql = "UPDATE $table SET " . implode(',', $args) . " WHERE id = ?";
           

            $stmt = $this->pdo->prepare($sql);

            if (!$stmt) {
                die("Error in prepared statement: " . $this->pdo->errorInfo()[2]);
            }

            // Bind parameters to the prepared statement

            $i = 1;
            foreach ($data as $key => &$value) {
                $stmt->bindParam($i, $value);
                $i++;
            }
            $stmt->bindParam($i, $id);
            

            // Execute the prepared statement
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function deleteRecord(string $table, int $id)
    {
        try {
            // Use prepared statements to prevent SQL injection
            $sql = "DELETE FROM $table WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);



            // Bind parameters to the prepared statement
            $stmt->bindParam(1, $id);

            // Execute the prepared statement
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getTagByName($tagName)
    {
        $sql = "SELECT * FROM tag WHERE name = :tagName";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':tagName', $tagName, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function readwiki()
    {
        try {
            $query = "
                SELECT 
                article.*, 
                categorie.name AS categorie_name,
                user.name AS user_name,
                tag.name AS tag_name
                FROM pivot
                LEFT JOIN article ON article.id = pivot.article_id
                LEFT JOIN categorie ON article.categorie_id = categorie.id
                LEFT JOIN user ON article.user_id = user.id
                LEFT JOIN tag ON pivot.tag_id = tag.id
                WHERE user.id = :user_id
            ";
    
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':user_id', $_SESSION['user_id'], \PDO::PARAM_INT);
            $statement->execute();
    
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}



