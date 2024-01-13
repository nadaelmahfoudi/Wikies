<?php

require_once 'Model.php';
require_once 'CategorieModel.php';

class WikiModel extends Model
{
    public function getAllWikiEntries()
    {
        return $this->selectRecords('wiki');
    }

    public function addWikiEntry($title, $content, $dateCreate, $status, $description, $userId, $categoryId, $tags)
    {
        // Process the form data only when the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $dateCreate = date('Y-m-d H:i:s');
            $status = $_POST['status'];
            $description = $_POST['description'];
            $user_id = $_POST['user_id'];
    
            $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;
            if ($categoryId === null) {
                echo 'Error: Category is required.';
                exit;
            }
    
            // Ensure $tags is a string
            if (is_array($tags)) {
                $tags = implode(',', $tags);
            }
    
            // Insert wiki entry
            $result = $this->insertWikiEntry($title, $content, $dateCreate, $status, $description, $userId, $categoryId);
    
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

public function getTagsForWikiEntry($wikiId)
{
    try {
        // Assuming there is a pivot table named wiki_tags that links wikis and tags
        $sql = "SELECT tag.* FROM tag
                JOIN wiki_tags ON tag.id = wiki_tags.tag_id
                WHERE wiki_tags.wiki_id = :wikiId";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':wikiId', $wikiId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle the exception (you may want to log it or throw a custom exception)
        return [];
    }
}
    

    public function updateWikiEntry($wikiId, $title, $content, $dateCreate, $status, $description, $user_id, $categoryId)
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

        $where = 'id = ' . $wikiId;

        return $this->updateRecord('wiki', $data, $where);
    }

    public function deleteWikiEntry($wikiId)
    {
        return $this->deleteRecord('wiki', $wikiId);
    }

    public function getAllCategories()
    {
        return $this->selectRecords('categorie');
    }

    public function searchWikiByTitle($title) {
        
        $result = array('title' => $title);

        return $result;
    }
}
