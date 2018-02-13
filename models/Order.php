<?php

class Order {
    //put your code here
    public static function save($userName,$userPhone,$userComment,$userId,$productsInCart)
    {
        $products = json_encode($productsInCart);
        
        $db = Db::getConnection();
        
        $sql = 'INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products)'
                . ' VALUES (:user_name, :user_phone, :user_comment, :user_id, :products)';
        $result = $db ->prepare($sql);
        $result ->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result ->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result ->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result ->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $result ->bindParam(':products', $products, PDO::PARAM_STR);
        
        return $result->execute();
        
    }
    
    public static function getOrderListAdmin()
    {
        $db = Db::getConnection();
        
        $result = $db->query( 'SELECT * FROM product_order ');
        
        $order = array();
        $i = 0;
        while($row = $result->fetch()){
            $order[$i]['id'] = $row['id'];
            $order[$i]['user_name'] = $row['user_name'];
            $order[$i]['user_phone'] = $row['user_phone'];
            $order[$i]['user_comment'] = $row['user_comment'];
            $order[$i]['user_id'] = $row['user_id'];
            $order[$i]['date'] = $row['date'];
            $order[$i]['products'] = $row['products'];
            $order[$i]['status'] = $row['status'];
            $i++;
        }
        return $order;
    }
    
    public static function updateOrderById($id,$user_name,$user_phone,$user_comment,$date,$status)
    {
        $db = Db::getConnection();
        
        $sql = "UPDATE product_order SET user_name = :user_name, user_phone = :user_phone, user_comment = :user_comment, date = :date, status = :status WHERE id = :id";
        
        $result = $db->prepare($sql);
        $result->bindParam(':id',$id,PDO::PARAM_INT);
        $result->bindParam(':user_name',$user_name,PDO::PARAM_STR);
        $result->bindParam(':user_phone',$user_phone,PDO::PARAM_STR);
        $result->bindParam(':user_comment',$user_comment,PDO::PARAM_STR);
        $result->bindParam(':date',$date,PDO::PARAM_STR);
        $result->bindParam(':status',$status,PDO::PARAM_INT);
        return $result->execute();
        
    }
    
    public static function getOrderById($id)
    {
        $db = Db::getConnection();
        
        $sql = "SELECT * FROM product_order WHERE id = :id";
        
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id,PDO::PARAM_INT);
        $result ->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();   
        
        return $result->fetch();
    }

    public static function getStatusText($status)
    {
        if($status == 1){
            return "Новый заказ";
        }elseif($status == 2) {
            return "В обработке";
        }elseif($status == 3){
            return "Доставляется";
        }else{
            return "Закрыт";
        }
    }
}
