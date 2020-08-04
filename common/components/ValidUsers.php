<?php
namespace common\components;

use Yii;
// use backend\models\UserAccount;

class ValidUsers extends \yii\web\Request {

     private  $_userLayout;
     public $_userData;
     private $Session = [];
     // private $_dataUser;
     public function Setdata(){
        // $this->_dataUser =  UserAccount::findOne(['AccountID' => $this->_AccountID]);
        switch ($this->_userData->TypeUser){
                         case '1':
                             $this->_userLayout = "/admin";
                             break;
                         case '2':
                             $this->_userLayout = "/main";
                             break;
                         case '3':
                             $this->_userLayout = "/";
                             break;
                     }
       $this->Session['LayoutUser'] = $this->_userLayout;
       $this->Session['UserName'] = $this->_userData->UserName;
       $this->Session['AccountID'] = $this->_userData->AccountID;
       $this->Session['TypeUser'] = $this->_userData->TypeUser;
       $this->Session['PhotoUrl'] = $this->_userData->PhotoUrl;
       $this->Session['RoleID'] = $this->_userData->userByRole->RoleID;
        
     Yii::$app->session->set('UserData', $this->Session);

     }

     public function AccesControl($Array = NULL){

        $DataUser = Yii::$app->session->get('UserData');
        if($DataUser === NULL){
            Yii::$app->getResponse()->redirect(Yii::$app->urlManager->createUrl('/site/index'));
                    return FALSE;
        }

        if(isset($DataUser['TypeUser']) && in_array($DataUser['TypeUser'] , $Array)){

                    return TRUE;

                } else {

                    Yii::$app->getResponse()->redirect(Yii::$app->urlManager->createUrl('/'));
                    return FALSE;

                }
    }

} 