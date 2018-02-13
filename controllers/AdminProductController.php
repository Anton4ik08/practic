<?php


/**
 * Description of AdminProductController
 *
 * @author anton
 */
class AdminProductController extends AdminBase {
    //put your code here
    public function actionIndex()
    {
        self::checkAdmin();
        
        $productsList = Product::getProductsList();
        
        require_once (ROOT . '/views/admin_product/index.php');
        return true;
    }
    
    public function actionDelete($id)
    {
        self::checkAdmin();
        
        if(isset($_POST['submit'])){
            Product::deleteProductById($id);
            
            header("Location: /admin/product");
        }
        
        require_once (ROOT . '/views/admin_product/delete.php');
        return true;
    }
    public function actionCreate()
    {
        self::checkAdmin();
        
        $categoriesList = Category::getCategoriesListAdmin();
        
        if(isset($_POST['submit'])){
            
            $options['name'] = filter_input(INPUT_POST,'name');
            $options['code'] = filter_input(INPUT_POST,'code');
            $options['price'] = filter_input(INPUT_POST,'price');
            $options['category_id'] = filter_input(INPUT_POST,'category_id');
            $options['brand'] = filter_input(INPUT_POST,'brand');
            $options['availability'] = filter_input(INPUT_POST,'availability');
            $options['description'] = filter_input(INPUT_POST,'description');
            $options['is_new'] = filter_input(INPUT_POST,'is_new');
            $options['is_recommended'] = filter_input(INPUT_POST,'is_recommended');
            $options['status'] = filter_input(INPUT_POST,'status');
            
            
            $errors = false;
            
            //Валидация полей
            if(!isset($options['name']) || empty($options['name'])){
                $errors[] = 'Заполните поля';
            }
            if($errors == false){
                $id = Product::createProduct($options);
                
            }
            if($id){
                //echo '<pre>' . print_r($_FILES["image"]);die;
                //проверяем загрузился ли файл нормально
                if(is_uploaded_file($_FILES["image"]["tmp_name"])){
                    //перемещаем файл из временной папки по указанному нами пути в постоянную папку
                    move_uploaded_file($_FILES["image"]["tmp_name"],$_SERVER['DOCUMENT_ROOT'] . "/template/images/home/{$id}.jpg");
                }
            };
            // Перенаправляем пользователя на страницу управлениями товарами
                header("Location: /admin/product");
        }
        require_once(ROOT . '/views/admin_product/create.php');
        return true;
    }
    
    public function actionUpdate($id)
    {
        self::checkAdmin();
        
        $categoriesList = Category::getCategoriesListAdmin();
        
        $product = Product::getLatestProductID($id);
        
        if(isset($_POST['submit'])){
            
            $options['name'] = filter_input(INPUT_POST,'name');
            $options['code'] = filter_input(INPUT_POST,'code');
            $options['price'] = filter_input(INPUT_POST,'price');
            $options['category_id'] = filter_input(INPUT_POST,'category_id');
            $options['brand'] = filter_input(INPUT_POST,'brand');
            $options['availability'] = filter_input(INPUT_POST,'availability');
            $options['description'] = filter_input(INPUT_POST,'description');
            $options['is_new'] = filter_input(INPUT_POST,'is_new');
            $options['is_recommended'] = filter_input(INPUT_POST,'is_recommended');
            $options['status'] = filter_input(INPUT_POST,'status');
            
            
            if(Product::updateProductByID($id,$options)){
                
                if(is_uploaded_file($_FILES["image"]["tmp_name"])){
                    
                    move_uploaded_file($_FILES["image"]["tmp_name"],$_SERVER['DOCUMENT_ROOT'] . "/template/images/home/{$id}.jpg");
                }
            }
            // Перенаправляем пользователя на страницу управлениями товарами
                header("Location: /admin/product");
        }
        require_once (ROOT . '/views/admin_product/update.php');
        return true;
    }
    
}
