<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

class RecursivDelete extends \yii\base\Model
{
    /**
     * Creates and populates a set of models.
     *
     * @param string $modelClass
     * @param array $multipleModels
     * @return array
     */

public function deleteRecursive($relations = []) {
                
    foreach($relations as $relation) {
        
        if(is_array($this->$relation)) {
 
            foreach($this->$relation as $relationItem){
                         $relationItem->deleteRecursive();
                     }
 
        } else {
            
            if(isset($this->$relation)){
                $this->$relation->deleteRecursive();
            }
 
        }
 
    }
                
    $this->delete();
    
    return true;
    
}


}