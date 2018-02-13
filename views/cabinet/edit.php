<?php include (ROOT . '/views/layouts/header.php'); ?>

<section>
    <div class="container">
        <div class="row">
            
            <div class="col-sm-4 col-sm-offset-4 padding-right">
                
                <?php if($result): ?>
                    <p>Данные отредактированы!</p>
                <?php else: ?>
                    <?php if(isset($errors) && is_array($errors)): ?>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><span class="redOff"> * </span><?php echo $error;?></li>
                            <?php endforeach;?>
                        </ul>
                    <?php endif; ?>
                    <div class="signup-form">
                        <h2>Редактирование Данных</h2>
                        <form action="#" method="POST">
                            <input type="text" name="name" placeholder="Имя" value="<?php echo $name; ?>">
                            <input type="password" name="password" placeholder="Пароль" value="<?php echo $password; ?>">
                            <input type="submit" name="submit" value="Изменить" class="btn btn-default">
                        </form>
                    </div>
                <?php endif; ?>   
            </div>
        </div>
    </div>
</section>

<?php include (ROOT . '/views/layouts/footer.php'); ?>