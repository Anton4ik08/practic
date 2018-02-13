<?php include (ROOT . '/views/layouts/header.php'); ?>

<section>
    <div class="container">
        <div class="row">
            
            <div class="col-sm-4 col-sm-offset-4 padding-right">
                <?php if(isset($result) && $result !== FALSE): ?>
                        <p class="regOn">Вы зарегистрированы!</p>
                <?php else: ?>
                        <?php if(isset($errors) && is_array($errors)):?>
                            <ul>
                            <?php foreach ($errors as $error): ?>
                                <li> <span class="redOff"> * </span> <?php echo $error; ?>
                            <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    <div class="signup-form">
                        <h2>Регистрация на сайте</h2>
                        <form action="#" method="post">
                            <input type="text" name="name" placeholder="Имя" value="<?php echo $name; ?>">
                            <input type="email" name="email" placeholder="E-mail" value="<?php echo $email; ?>">
                            <input type="password" name="password" placeholder="Пароль" value="<?php echo $password; ?>">
                            <input type="submit" name="submite" class="btn btn-default" value="Регистрация">
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include (ROOT . '/views/layouts/footer.php'); ?>