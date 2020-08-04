<?php
namespace common\components;

use Yii;

class MyAccessControl extends \yii\web\Request {

     public function Verify($Array = NULL){

            if(!Yii::$app->user->isGuest){
                if($Array == NULL)
                    return Yii::$app->user->identity;
                    
                if(in_array(Yii::$app->user->identity->TypeUser, $Array))
                    return Yii::$app->user->identity;
            }
       Yii::$app->getResponse()->redirect(Yii::$app->urlManager->createUrl('/'));
        Yii::$app->end();
        return FALSE;
       
    }

} 