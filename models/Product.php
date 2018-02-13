<?php


class Product {
    //put your code here
    const SHOW_BY_DEFAULT = 3;
    /**
     * Возвращает список товаров для слайдера в многомерном массиве
     * @return array товары для слайдера
     */
    public static function getRecommended()
    {
        $db = Db::getConnection();
        
        $recommended = array();
        
        $result = $db -> query('SELECT id,name,price,is_new,is_recommended FROM product '
                . 'WHERE status = "1" AND is_recommended = "1" '
                . 'ORDER BY id DESC '
                );
        
        
        $i = 0;
        while($row = $result -> fetch()){
            $recommended[$i]['id'] = $row['id'];
            $recommended[$i]['name'] = $row['name'];
            $recommended[$i]['price'] = $row['price'];
            
            $recommended[$i]['is_new'] = $row['is_new'];
            $recommended[$i]['is_recommended'] = $row['is_recommended'];
            $i++;
        }
        return $recommended;
    }
    /**
     * Получает список всех товаров из БД
     * @return type
     */
    public static function getProductsList()
    {
        $db = Db::getConnection();
        
        $result = $db->query('SELECT id,name,price,code FROM product ORDER BY id ASC');
        $productList = array();
        $i = 0;
        while($row = $result ->fetch()){
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['code'] = $row['code'];
            $i++;
        }
        return $productList;
    }
    /**
     * Удаляет товар по id
     * @param integer $id Description
     * @return bulion Description
     */
    public static function deleteProductById($id)
    {
        $db = Db::getConnection();
        
        $sql = 'DELETE FROM product WHERE id = :id';
        
        $result = $db ->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Добавляем новый товар  
     * @param array массив с товарами
     * @return int id добавленного товара
     */
    public static function createProduct($options)
    {
        
        $db = Db::getConnection();
        
        $sql = 'INSERT INTO product '
                . '(name,category_id,code,price,availability,brand, '
                . 'description ,is_new,is_recommended,status) '
                .'VALUES '
                . '(:name, :category_id, :code, :price,:availability, :brand, '
                . ' :description , :is_new, :is_recommended, :status)';
        
        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'],PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'],PDO::PARAM_INT);
        $result->bindParam(':code', $options['code'],PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'],PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'],PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'],PDO::PARAM_STR);
        
        $result->bindParam(':description', $options['description'],PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'],PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'],PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'],PDO::PARAM_INT);
        if($result->execute()){
            return $db->lastInsertId();
        }
        return 0;
    }
    public static function getLatestProduct($count = self::SHOW_BY_DEFAULT)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT id, name, price, is_new FROM product '
                . 'WHERE status = "1" ORDER BY id DESC '
                . 'LIMIT :count';

        // Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':count', $count, PDO::PARAM_INT);

        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        // Выполнение коменды
        $result->execute();

        // Получение и возврат результатов
        $i = 0;
        $productsList = array();
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['price'] = $row['price'];
           
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productsList;
    }
    
    public static function getLatestProductID($id)
    {
        $id = intval($id);
        
        if($id){
        $db = Db::getConnection();
        $result = $db -> query('SELECT * FROM product WHERE id = '.$id);
        $result ->setFetchMode(PDO::FETCH_ASSOC);
        
        return $result->fetch();
        }
    }
    
    public static function updateProductByID($id,$options)
    {
        $db = Db::getConnection();
        
        $sql = "UPDATE product "
                . "SET name = :name ,"
                . "code = :code, "
                . "price = :price, "
                . "category_id = :category_id, "
                . "brand = :brand, "
                . "availability = :availability, "
                . "description = :description, "
                . "is_new = :is_new, "
                . "is_recommended = :is_recommended, "
                . "status = :status "
                . "WHERE id = :id";
        
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id,PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'],PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'],PDO::PARAM_INT);
        $result->bindParam(':code', $options['code'],PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'],PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'],PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'],PDO::PARAM_STR);
        
        $result->bindParam(':description', $options['description'],PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'],PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'],PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'],PDO::PARAM_INT);
        return $result->execute();
        
    }


    public static function getProductListByCategory($categoryID = false,$page = 1)
    {
        
        
        if($categoryID){
            
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
            $db = Db::getConnection();
            
            $product =array();
            $result = $db -> query("SELECT id,name,price,is_new FROM product "
                . "WHERE status = '1' AND category_ID = ' $categoryID ' "
                . "ORDER BY id DESC "
                . "LIMIT ". self::SHOW_BY_DEFAULT
                . ' OFFSET ' . $offset);
            
            $i = 0;
        while($row = $result -> fetch()){
            $product[$i]['id'] = $row['id'];
            $product[$i]['name'] = $row['name'];
            $product[$i]['price'] = $row['price'];
           
            $product[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $product;
        }
    }
    public static function getTotalProductsInCategory($categoryID)
    {
        $db = Db::getConnection();
        
        $result = $db ->query('SELECT count(id) AS count FROM product '
                . 'WHERE status ="1" AND category_id = "' . $categoryID .'"');
        $result ->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result ->fetch();
        
        return $row['count'];
    }
    
    public static function getProductsByIds($idsArray)
    {
        $products = array();
        
        $db = Db::getConnection();
        
        $idsString = implode(',',$idsArray);
        
        
        $sql = "SELECT * FROM product WHERE status ='1' AND id IN ($idsString)";
        
        $result = $db -> query($sql);
        $result ->setFetchMode(PDO::FETCH_ASSOC);
        
        $i = 0;
        while($row = $result->fetch()){
            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['price'] = $row['price'];
            $i++;
        }
        
        return $products;
    }
    /**
     * Проверяет есть ли у товара изображение если нет подставляет шаблон
     * @param type $id
     * @return string
     */
    public static function getImage($id)
    {
        // Название изображения-пустышки
        $noImage = 'no-image.jpg';

        // Путь к папке с товарами
        $path = '/template/images/home/';

        // Путь к изображению товара
        $pathToProductImage = $path . $id . '.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
            // Если изображение для товара существует
            // Возвращаем путь изображения товара
            return $pathToProductImage;
        }

        // Возвращаем путь изображения-пустышки
        return $path . $noImage;
    }
}
