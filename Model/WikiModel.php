<?php

require_once 'Model.php';
require_once 'CategorieModel.php';

class WikiModel extends Model
{

    public function getAllWikiEntries() 
    {
        return $this->selectRecords('wiki');
    }
    public function getAcceptedWikies() 
    {
        return $this->selectRecords('wiki','*','status = 1');
    }

    public function addWikiEntry($title, $content, $dateCreate, $status, $description, $userId, $categoryId, $tags)
    {
        // Process the form data only when the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $dateCreate = date('Y-m-d H:i:s');
            $description = $_POST['description'];
    
            $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;
            if ($category_id === null) {
                echo 'Error: Category is required.';
                exit;
            }
    
            // Ensure $tags is a string
            if (is_array($tags)) {
                $tags = implode(',', $tags);
            }
            $user_id = $_SESSION['idUser'] ?? 2;


            $result = $this->insertRecord('wiki',compact('title','content','dateCreate','description','user_id','category_id'));
    
    
            if (!$result) {
                echo 'Error adding wiki entry.';
                exit;
            }
    
            // Get the ID of the newly inserted wiki entry
            $lastInsertId = $this->pdo->lastInsertId();
    
            // Insert tags
            if (!empty($tags)) {
                $tagModel = new TagModel();
                $tagNames = explode(',', $tags);
    
                foreach ($tagNames as $tagName) {
                    $tagName = trim($tagName);
    
                    // Check if the tag already exists
                    $existingTag = $tagModel->getTagByName($tagName);
    
                    if (!$existingTag) {
                        // If the tag doesn't exist, add it
                        $tagModel->addTag($tagName);
    
                        // Get the ID of the newly inserted tag
                        $tagId = $this->pdo->lastInsertId();
                    } else {
                        // If the tag already exists, use its ID
                        $tagId = $existingTag['id'];
                    }
    
                    // Associate the tag with the wiki entry
                    $this->addWikiTag($lastInsertId, $tagId);
                }
            }
    
            header('Location: /?page=Wiki');
            exit;
        }
    }
    
    public function updateWikiStatus($wikiId, $newStatus) {
        
        $query = "UPDATE wiki SET status = :newStatus WHERE id = :wikiId";
        if($newStatus == 0){
            $newStatus = 1;
        }else{
            $newStatus == 0;
        }
        $stmt = $this->pdo->prepare($query);
        $params = array(':newStatus' => $newStatus, ':wikiId' => $wikiId);
    
        return $stmt->execute($params);
    }

    private function insertWikiEntry($title, $content, $dateCreate, $status, $description, $userId, $categoryId)
    {
        $data = array(
            'title' => $title,
            'content' => $content,
            'datecreate' => $dateCreate,
            'status' => $status,
            'description' => $description,
            'user_id' => $userId,
            'category_id' => $categoryId
        );
    
        return $this->insertRecord('wiki', $data);
    }
    
    

    public function addWikiTag($wikiId, $tagId)
{
    // Use prepared statements to prevent SQL injection
    try {
        $sql = "INSERT INTO wiki_tags (wiki_id, tag_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);

        // Bind parameters to the prepared statement
        $stmt->bindParam(1, $wikiId, PDO::PARAM_INT);
        $stmt->bindParam(2, $tagId, PDO::PARAM_INT);

        // Execute the prepared statement
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        return false;
    }
}


    // public function updateWikiEntry($wikiId, $title, $content, $dateCreate, $status, $description, $user_id, $categoryId)
    // {
    //     $data = array(
    //         'title' => $title,
    //         'content' => $content,
    //         'datecreate' => $dateCreate,
    //         'status' => $status,
    //         'description' => $description,
    //         'user_id' => $userId,
    //         'category_id' => $categoryId
    //     );

    //     $where = 'id = ' . $wikiId;

    //     return $this->updateRecord('wiki', $data, $where);
    // }

    public function deleteWikiEntry($wikiId)
    {
        return $this->deleteRecord('wiki', $wikiId);
    }

    public function getAllCategories()
    {
        return $this->selectRecords('categorie');
    }



// Add a new method to retrieve detailed information for a single wiki entry
public function getWikiDetails($wikiId) {
    $sql = "SELECT * FROM wiki WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':id', $wikiId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$result) {
        // Handle the case when no result is found, e.g., return an empty array or null
        return null;
    }
    
    // Fetch tags for the wiki entry
    $result['tags'] = $this->getWikiTags($wikiId);
    
    return $result;
}

// Add a new method to retrieve tags for a wiki entry
public function getWikiTags($wikiId)
    {
        $sql = "SELECT GROUP_CONCAT(t.tag_name) AS concatenated_tags
                FROM tag t
                JOIN wiki_tags wt ON t.id = wt.tag_id
                WHERE wt.wiki_id = :wiki_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':wiki_id', $wikiId, PDO::PARAM_INT);
        $stmt->execute();
        $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $tags;
    }


    public function searchWikiByTitle($input) {
        $sql = "SELECT * FROM wiki WHERE title LIKE :input";
        $stmt = $this->pdo->prepare($sql);
    
        // Use bindValue instead of bindParam
        $stmt->bindValue(':input', '%' . $input . '%', PDO::PARAM_STR);
    
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

public function singlePageDetail($wikiId)
{
    $sql = "SELECT wiki.id, wiki.title, wiki.content, wiki.status AS is_archived,
                   wiki.datecreate, wiki.description,
                    categorie.category_name AS category,
                   GROUP_CONCAT(tag.tag_name ORDER BY tag.tag_name ASC SEPARATOR ', ') AS tags
            FROM wiki
                 
                 INNER JOIN categorie ON wiki.category_id = categorie.id
                 LEFT JOIN wiki_tags ON wiki.id = wiki_tags.wiki_id
                 LEFT JOIN tag ON wiki_tags.tag_id = tag.id
            WHERE wiki.id = :wikiId
            GROUP BY wiki.id";

    try {
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':wikiId', $wikiId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return null;
    }
}

public function getWikiesByUserId($userId) 
{
    $sql = "SELECT * FROM wiki WHERE user_id = :userId";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function updateWiki($wikiId, $title, $content, $dateCreate, $description, $categoryId)
{
    $dateCreate = str_replace("T", ' ',  $dateCreate) . ":00";
    $data = array('title' => $title , 'content' => $content , 'datecreate' => $dateCreate , 'description' => $description , 'category_id' => $categoryId);    
    return $this->updateRecord('wiki', $data, $wikiId);
}




}