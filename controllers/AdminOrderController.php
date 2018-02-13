<?php
/**
 * Контроллер для управления заказами
 *
 * @author anton
 */
class AdminOrderController extends AdminBase {
    //put your code here
    public function actionIndex()
    {
        self::checkAdmin();
        
        $ordersList = Order::getOrderListAdmin();
        
        require_once (ROOT . '/views/admin_order/index.php');
        return true;
    }
    
    public  function actionUpdate($id)
    {
        self::checkAdmin();
        
        $order = Order::getOrderById($id);
        
        if(isset($_POST['submit'])){
            $user_name = filter_input(INPUT_POST,'userName');
            $user_phone = filter_input(INPUT_POST,'userPhone');
            $user_comment = filter_input(INPUT_POST,'userComment');
            $date = filter_input(INPUT_POST,'date');
            $status = filter_input(INPUT_POST,'status');
            
            Order::updateOrderById($id,$user_name,$user_phone,$user_comment,$date,$status);
               
           header("Location: /admin/order");
        }
        require_once(ROOT . '/views/admin_order/update.php');
        return true;
    }
    
    public function actionView($id)
    {
        self::checkAdmin();
        
        $order = Order::getOrderById($id);
        
        $productsQuantity = json_decode($order['products'],true);
        
        $productsIds = array_keys($productsQuantity);
        
        $products = Product::getProductsByIds($productsIds);
        
        require_once(ROOT . '/views/admin_order/view.php');
        return true;
    }
}

