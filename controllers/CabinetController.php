<?php


class CabinetController {
    //put your code here
    public function actionIndex()
    {
        $userId = User::checkLogget();
        
        $user = User::checkUserById($userId);
        
        require_once (ROOT . '/views/cabinet/index.php');
        
        return true;
    }
    
    public function actionEdit()
    {
        $userId = User::checkLogget();
        
        $user = User::checkUserById($userId);
        
        $name = $user['name'];
        $password = $user['password'];
        
        $result = false;
        
        if(isset($_POST['submit'])){
            
            $name = filter_input(INPUT_POST, 'name');
            $password = filter_input(INPUT_POST, 'password');
            
            $errors = false;
            
            if(!User::checkName($name)){
               $errors[] = 'Имя не должно быть короче 2-х символов!';
            }
            if(!User::checkPassword($password)){
                $errors[] = 'Пароль не должно быть короче 6-х символов!';
            }
            if($errors == false){
                $result = User::Edit($userId,$name,$password);
            }
        }
        
        require_once (ROOT . '/views/cabinet/edit.php');
        
        return true;
    }
}
