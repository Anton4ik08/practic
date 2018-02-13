<?php

class Cart {
    //put your code here
    public static function addProduct($id){
        $id = intval($id);
        
        $productsInCart = array();
        
        if(isset($_SESSION['products'])){
            
            $productsInCart = $_SESSION['products'];
        }
        
        if(array_key_exists($id, $productsInCart)){
            $productsInCart["$id"] ++;
        }else{
            $productsInCart["$id"] = 1;
        }
        //unset($productsInCart);
        $_SESSION['products'] = $productsInCart;
        //echo '<pre>' ; print_r($_SESSION['products']);die;
        return self::countItems();
        
    }
    public static function delete($id)
    {
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productsInCart = self::getProducts();
        // Удаляем из массива элемент с указанным id
        if($productsInCart[$id] > 1){
            $productsInCart[$id] --;
        } else {
            unset($productsInCart[$id]);
        }
        
        // Записываем массив товаров с удаленным элементом в сессию
        $_SESSION['products'] = $productsInCart;
    }

    public static function countItems()
    {
        
        if(isset($_SESSION['products'])){
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity){
                $count = $count + $quantity;
            }
            
            return $count;
        }else {
            return 0;
        }
    }
    
    public static function getProducts()
    {
        if(isset($_SESSION['products'])){
            
            return $_SESSION['products'];
        }
        return false;
    }
    
    public static function getTotalPrice($products)
    {
        $productsInCart = self::getProducts();
        
        $total = 0;
        
        if($productsInCart){
            foreach ($products as $item){
                
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }
        return $total;
    }
    
    public static function clear()
    {
        if(isset($_SESSION['products'])){
            unset($_SESSION['products']);
        }
    }
}
