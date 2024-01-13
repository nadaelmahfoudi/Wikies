<?php
require_once 'Model.php';

class TagModel extends Model
{
    public function getAllTags()
    {
        return $this->selectRecords('tag');        
    }

    public function findTagById($id)
    {
        return $this->getElementById('tag', $id);
    }

    public function findTagByName($tagName)
    {
        $condition = "tag_name = '$tagName'";
        return $this->selectRecords('tag', $condition);
    }

    public function addTag($tagName)
    {
        $data = array('tag_name' => $tagName);
        return $this->insertRecord('tag', $data);
    }

    public function updateTag($tagId, $tagName)
    {
        $data = array('tag_name' => $tagName);
        $where =  $tagId;
        
        return $this->updateRecord('tag', $data, $where);
    }

    public function deleteTag($tagId)
    {
        return $this->deleteRecord('tag', $tagId);
    }
}
?>
