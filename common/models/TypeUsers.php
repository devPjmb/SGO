<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class TypeUsers extends ActiveRecord
{
    
    public static function tableName()
    {
        return '{{%TypeUsers}}';
    }

  /**
 	* @return \yii\db\ActiveQuery
	 */
	public function getUserAccount()
	{
	    return $this->hasMany(UserAccount::className(), ['TypeUser' => 'TypeUsersID']);
	}




}
?>