<?php


/**
 * Управление разделом категории
 *
 * @author anton
 */
class AdminCategoryController extends AdminBase{
    //put your code here
    public function actionIndex()
    {
        self::checkAdmin();
        
        $categoriesList = Category::getCategoriesListAdmin();
        
        require_once (ROOT . '/views/admin_category/index.php');
        return true;
    }
    
    public function actionDelete($id)
    {
        self::checkAdmin();
        
        if(isset($_POST['submit'])){
            Category::deleteCategoryById($id);
            
            header("Location: /admin/category");
        }
        
        require_once (ROOT . '/views/admin_category/delete.php');
        return true;
    }
    
    public function actionCreate()
    {
        self::checkAdmin();
        
        $categoriesList = Category::getCategoriesListAdmin();
        
        if(isset($_POST['submit'])){
            
            $options['name'] = filter_input(INPUT_POST,'name');
            $options['sort_order'] = filter_input(INPUT_POST,'sort_order');
            $options['status'] = filter_input(INPUT_POST,'status');
            
            $errors = false;
            
            //Валидация полей
            if(!isset($options['name']) || empty($options['name'])){
                $errors[] = 'Заполните поля';
            }
            if($errors == false){
                 Category::createCategory($options);
                
            }
            
            // Перенаправляем пользователя на страницу управлениями товарами
                header("Location: /admin/category");
        }
        require_once(ROOT . '/views/admin_category/create.php');
        return true;
    }
    
    public function actionUpdate($id)
    {
        self::checkAdmin();
        
        $categoriesList = Category::getCategoriesListAdmin();
        
        $category = Category::getLatestCategoryID($id);
        
        if(isset($_POST['submit'])){
            
            $options['name'] = filter_input(INPUT_POST,'name');
            $options['sort_order'] = filter_input(INPUT_POST,'sort_order');
            $options['status'] = filter_input(INPUT_POST,'status');
            
            $errors = false;
            
            //Валидация полей
            if(!isset($options['name']) || empty($options['name'])){
                $errors[] = 'Заполните поля';
            }
            if($errors == false){
                 Category::updateCategoryByID($id,$options);
                
            }
            
            // Перенаправляем пользователя на страницу управлениями товарами
                header("Location: /admin/category");
        }
        require_once(ROOT . '/views/admin_category/update.php');
        return true;
    }
}
