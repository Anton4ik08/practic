<?php


class Category {
    //put your code here
    public static function GetCategoriesList()
    {
        $db = Db::getConnection();
        
        $categoryList = array();
        
        $result = $db -> query('SELECT id,name FROM category '
                . 'ORDER BY sort_order ASC');
       
        
        $i = 0;
        while($row = $result -> fetch()){
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $i++;
        }
        return $categoryList;
    }
    
    public static function getCategoriesListAdmin(){
        
        $db = Db::getConnection();
        
        $result = $db->query('SELECT id,name,sort_order,status FROM category ORDER BY sort_order ASC');
        
        $categoryList = array();
        $i = 0;
        while($row = $result->fetch()){
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
            $categoryList[$i]['sort_order'] = $row['sort_order'];
            $categoryList[$i]['status'] = $row['status'];
            $i++;
        }
        return $categoryList;
    }
    
    public static function deleteCategoryById($id)
    {
        $db = Db::getConnection();
        
        $sql = 'DELETE FROM category WHERE id = :id';
        
        $result = $db ->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
    
    public static function createCategory($options)
    {
        
        $db = Db::getConnection();
        
        $sql = 'INSERT INTO category '
                . '(name,sort_order,status) '
                .'VALUES '
                . '(:name, :sort_order, :status)';
        
        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'],PDO::PARAM_STR);
        $result->bindParam(':sort_order', $options['sort_order'],PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'],PDO::PARAM_INT);
        
        return $result->execute();
         
    }
    
    public static function updateCategoryByID($id,$options)
    {
        $db = Db::getConnection();
        
        $sql = "UPDATE category "
                . "SET name = :name ,"
                . "sort_order = :sort_order, "
                . "status = :status, "
                . "WHERE id = :id";
        
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id,PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'],PDO::PARAM_STR);
        $result->bindParam(':sort_order', $options['sort_order'],PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'],PDO::PARAM_INT);
        
        return $result->execute();
}

public static function getLatestCategoryID($id)
{
    $db = Db::getConnection();
    
    $sql = 'SELECT * FROM category WHERE id = :id';
    
    $result = $db->prepare($sql);
    $result->bindParam(':id', $id,PDO::PARAM_INT);
    $result ->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();   
        
    return $result->fetch();
}

public static function getStatusText($status)
{
    if($status == 1){
        return 'Отображается';
    } else {
        return 'Скрыта';
    }
}
}