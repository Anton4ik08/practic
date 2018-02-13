<?php


/**
 * Description of AdminController
 *
 * @author anton
 */
class AdminController extends AdminBase
{
    //put your code here
    
    public function actionIndex()
    {
        self::checkAdmin();
        
        require_once (ROOT . '/views/admin/index.php');
        return true;
    }
    
}
