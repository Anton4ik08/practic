<?php

/**
 * Description of AdminBase
 *
 * @author anton
 */
abstract class AdminBase {
    //put your code here
    /**
     * проверяет есть ли у пользователя правва Admina
     * @return boolean
     */
    public static function checkAdmin()
    {
        $userId = User::checkLogget();
        
        $user = User::checkUserById($userId);
        
        if($user['role'] == 'admin'){
            return true;
        }
        
        die ('Access denied');
    }
}
