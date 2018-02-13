<?php include (ROOT . '/views/layouts/header.php'); ?>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="left-sidebar">
                            <h2>Каталог</h2>
                            <div class="panel-group category-products">
                                <?php foreach ($categories as $categoryItem): ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a href="/category/<?php echo $categoryItem['id']; ?>"
                                                    class="<?php if($categoryID == $categoryItem['id']) echo 'active';?>">
                                                    <?php echo $categoryItem['name']; ?>
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                <?php endforeach; ?> 
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-9 padding-right">
                        <div class="features_items"><!--features_items-->
                            <h2 class="title text-center">Корзина</h2>
                            
                            <?php if($result): ?>
                                <p>Заказ оформлен.Мы вам перезвоним</p>
                            <?php else: ?>
                                <p>Выбрано товаров:<?php echo $totalQuantity; ?> на сумму: <?php echo $totalPrice ;?> $</p><br>
                                
                                    <div class="col-sm-4">
                                        <?php if(isset($errors) && is_array($errors)): ?>
                                            <ul>
                                                <?php foreach ($errors as $error): ?>
                                                    <li><span class="redOff"> * </span><?php echo $error ;?></li>
                                                <?php endforeach;?>
                                            </ul>
                                        <?php endif; ?>
                                        <p>Для оформления заказа ,заполните форму.Посл чего наш менеджер свяжется с вами.</p>

                                        <div class="login-form">
                                            <form action="#" method="POST">
                                                <input type="text" name="userName" placeholder="Имя" value="<?php echo $userName ;?>">
                                                <input type="number" name="userPhone" placeholder="Телефон" value="<?php echo $userPhone ;?>">
                                                <input type="text" name="userComment" placeholder="Пожелания" value="<?php echo $userComment ;?>">
                                                <br>
                                                <input type="submit" name="submit" class="btn btn-default" value="Оформить">
                                            </form>
                                        </div>
                                    </div>
                                <?php endif;?>
                               
                            
                        </div><!--features_items-->
                    </div>
                </div>
            </div>
        </section>
<?php include (ROOT . '/views/layouts/footer.php');?> 



