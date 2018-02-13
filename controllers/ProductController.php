<?php


class ProductController {
    //put your code here
    public function actionView($id){
        
        $categories =array();
        $categories = Category::GetCategoriesList();
        
        $product = Product::getLatestProductID($id);
        
        require_once (ROOT . '/views/product/view.php');
        
        return true;
    }
    
    
}
