<?php include (ROOT . '/views/layouts/header.php'); ?>

<section>
    <div class="container">
        <div class="row">
            
            <div class="col-sm-4 col-sm-offset-4 padding-right">
                
                <?php if($result): ?>
                    <p>Сообщение отправлено мы ответим вам на указанный адрес электронной почты.</p>
                <?php else: ?>
                    <?php if(isset($errors) && is_array($errors)): ?>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><span class="redOff"> * </span><?php echo $error;?></li>
                            <?php endforeach;?>
                        </ul>
                    <?php endif; ?>
                    <div class="signup-form">
                        <h2>Обратная связь</h2>
                        <h4>Есть вопрос ? Напиши нам</h4>
                        <form action="#" method="POST">
                            <input type="email" name="email" placeholder="Ваша почта" value="<?php echo $userEmail; ?>">
                            <input type="text" name="message" placeholder="Сообщение" value="<?php echo $userMessage; ?>">
                            <input type="submit" name="submit" value="Отправить" class="btn btn-default">
                        </form>
                    </div>
                <?php endif; ?>   
            </div>
        </div>
    </div>
</section>

<?php include (ROOT . '/views/layouts/footer.php');?>