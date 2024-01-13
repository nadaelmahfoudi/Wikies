<?php

require_once 'Model.php';
require_once 'CategorieModel.php';

class WikiModel extends Model
{
    public function getAllWikiEntries()
    {
        return $this->selectRecords('wiki');
    }

    public function addWikiEntry($title, $content, $dateCreate, $status, $description, $userId, $categoryId)
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

    public function updateWikiEntry($title, $content, $dateCreate, $status, $description, $user_id, $categoryId)
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
