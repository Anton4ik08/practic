<?php


class CartController {
    //put your code here
    public function actionAdd($id)
    {
        Cart::addProduct($id);
        
        $refferrer = $_SERVER['HTTP_REFERER'];
        header("Location: $refferrer");
    }
    
    public function actionDelete($id)
    {
        
        Cart::delete($id);
        
        header("Location:/cart");
    }

    public function actionAddAjax($id)
    {
        echo  Cart::addProduct($id);
        return true;
    }
    
    public function actionIndex()
    {
        $categories = array();
        $categories = Category::GetCategoriesList();
        
        $productsInCart = false;
        
        //получаем данные из корзины
        $productsInCart = Cart::getProducts();
        
        if($productsInCart){
            //получаем полную информацию о товарах для списка
            $productsIds = array_keys($productsInCart);
            
            $products = Product::getProductsByIds($productsIds);
            //получаем общию стоимость товара
            $totalPrice = Cart::getTotalPrice($products);
        }
        require_once (ROOT . '/views/cart/index.php');
        return true;
    }
    
    public function actionCheckout()
    {
        $categories = array();
        $categories = Category::GetCategoriesList();
        
        //статус успешного оформления заказа
        $result = false;
        
        //Форма отправлена?
        if(isset($_POST['submit'])){
            
            $userName = filter_input(INPUT_POST ,'userName');
            $userPhone = filter_input(INPUT_POST ,'userPhone');
            $userComment = filter_input(INPUT_POST ,'userComment');
            
            $errors = false;
            if(!User::checkName($userName)){
                $errors[] = 'Имя слишком короткое!';
            }
            if(!User::checkPhone($userPhone)){
                $errors[] = 'Неправильный номер телефона!';
            }
            if($errors == false){
                
                $productsInCart = Cart::getProducts();
                if(User::isGuest()){
                    $userId = false;
                }else{
                   $userId = User::checkLogget();
                }
                
                $result = Order::save($userName,$userPhone,$userComment,$userId,$productsInCart);
                
                if($result){
                    //Оповещаем админестратора о новом заказе
                    $adminEmail = 'admin@antontester.ru';
                    $message = 'http://antontester.ru/admin/orders';
                    $subject = 'Новый заказ';
                    $headers = "Content-type: text/html; charset=utf-8 \r\n"; //Кодировка письма
                    
                    mail($adminEmail,$subject,$message,$headers);
                   
                    
                    //очищаем корзину
                    Cart::clear();
                }
            } else {
                $productsInCart = Cart::getProducts();
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
            }
        } else {
        //Форма не отправлена
            $productsInCart = Cart::getProducts();
            //В корзине есть товары?- нет
            //Если нет отправляем пользователя на главную искать товары
            
            
            if($productsInCart == false){
                
                header("location:/");
            } else {
            
                //В корзине есть товары? - да
                //Итоги: Общая стоимость колличество товаров
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
                
                $userName = false;
                $userPhone = false;
                $userComment = false;
                
                if(User::isGuest()){
                    //нет
                    //значения для формы пустые
                } else {
                
                    $userId = User::checkLogget();
                    $user = User::checkUserById($userId);
                    
                    $userName = $user['name'];
                }
            }
        }
        require_once (ROOT . "/views/cart/checkout.php");
        return true;
        
    }
}
