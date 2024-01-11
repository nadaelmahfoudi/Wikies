<?php
require_once 'Model.php';

class CategorieModel extends Model
{
    public function getAllCategories()
    {
        return $this->selectRecords('categorie');
    }

    public function addCategory($categoryName)
    {
        $data = array('category_name' => $categoryName);
        return $this->insertRecord('categorie', $data);
    }

    public function updateCategory($categoryId, $categoryName)
    {
        $data = array('category_name' => $categoryName);
        $where = 'id = ' . $categoryId;
        return $this->updateRecord('categorie', $data, $where);
    }

    public function deleteCategory($categoryId)
    {
        return $this->deleteRecord('categorie', $categoryId);
    }
}
