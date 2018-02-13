<?php


class SiteController {
    //put your code here
    public function actionIndex(){
        
        $categories =array();
        $categories = Category::GetCategoriesList();
        
        $latestProducts = array();
        $latestProducts = Product::getLatestProduct(6);
         
        $recommended = array();
        $recommended = Product::getRecommended();
        
        require_once (ROOT . '/views/site/index.php');
        
        return true;
    
    }
    
    public function actionContact()
    {
        $userEmail = '';
        $userMessage = '';
        $result = false;
        
        if(filter_input(INPUT_POST,'submit')){
            $userEmail = filter_input(INPUT_POST, 'email');
            $userMessage = filter_input(INPUT_POST, 'message');
            
           $errors = false;
        
        
            if(!User::checkEmail($userEmail)){
                $errors = 'Неправильный E-mail !';
            }
            
            if($errors == false){
                $adminEmail = 'anton4ik08@mail.ru';
                $message = "Текст: {$userMessage}. от {$userEmail}";
                $subject = 'Тема письма';
                $result = mail($adminEmail, $subject, $message);
                $result = true;
            }
        }
        require_once (ROOT . '/views/site/contact.php');
        
        return true;
    }
      
}

