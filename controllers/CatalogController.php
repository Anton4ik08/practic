<?php


class CatalogController {
    //put your code here
    public function actionIndex(){
        
        $categories =array();
        $categories = Category::GetCategoriesList();
        
        $latestProducts = array();
        $latestProducts = Product::getLatestProduct(6);
                
        require_once (ROOT . '/views/catalog/index.php');
        
        return true;
    }
    
    public function actionCategory($categoryID,$page = 1){
        
        if($page > 1 && $page == 0){
                
                $page = explode('-',$page);
                $deletPage = array_shift($page);
                $page = $page[0];
                echo $page; 
                
            }
        
        $categories = array();
        $categories = Category::GetCategoriesList();
        
        $categoryProducts = array();
        $categoryProducts = Product::getProductListByCategory($categoryID,$page);
        
        $total = Product::getTotalProductsInCategory($categoryID);
        
        $pagination = new Pagination($total,$page,Product::SHOW_BY_DEFAULT, 'page-');
        
        require_once (ROOT . '/views/catalog/catalog.php');
        
        return true;
    }
}
