<?php


class UserController {
    //put your code here
    public function actionRegister()
    {
        $name ='';
        $email ='';
        $password ='';
        
        
        if(filter_input(INPUT_POST, 'submit')){
            
            $name = filter_input(INPUT_POST, 'name');
            $email = filter_input(INPUT_POST, 'email');
            $password = filter_input(INPUT_POST, 'password');
            
            $errors = false;
            $result = false;
            
            if(!User::checkName($name)){
               $errors[] = 'Имя не должно быть короче 2-х символов!';
            }
            if(!User::checkEmail($email)){
                $errors[] = 'Неправильный E-mail';
            }
            if(!User::checkPassword($password)){
                $errors[] = 'Пароль не должно быть короче 6-х символов!';
            }
            if(User::checkEmailExists($email)){
                $errors[] = 'Пользователь с таким E-mail уже существует!';
            }
            if($errors == false){
                $result = User::register($name, $email, $password);
            }
        }
        
        require_once (ROOT . '/views/user/register.php');
        
        return true;
    }
    
    public function actionLogin()
    {
        $email = '';
        $password = '';
        
        if(filter_input(INPUT_POST, 'submit')){
            $email = filter_input(INPUT_POST, 'email');
            $password = filter_input(INPUT_POST, 'password');
            
            $errors = false;
            
            if(!User::checkEmail($email)){
                $errors[] = 'Неправильный E-mail';
            }
            if(!User::checkPassword($password)){
                $errors[] = 'Пароль не должно быть короче 6-х символов!';
            }
            
            $userId = User::checkUserData($email, $password);
            
            if($userId == false){
                $errors[] = 'Неправильные данные для входа на сайт! ';
            } else {
                User::auth($userId);
                
                header("Location: /cabinet/");
            }
        }
        
        require_once (ROOT . '/views/user/login.php');
        
        return true;
    }
    
    public function actionLogout()
    {
        
        unset($_SESSION["user"]);
        header("Location: /");
    }
}
