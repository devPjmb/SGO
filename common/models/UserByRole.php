<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class UserByRole extends ActiveRecord
	{
		public static function tableName()
		{
			return '{{%UserByRole}}';
		}

		public function rules(){
			return [
	            [['RoleID'],'integer', 'integerOnly'=>true],
	            
	        ];
		}

		/**
	    * @return \yii\db\ActiveQuery
	     */
	    public function getRole()
	    {
	        return $this->hasOne(Role::className(), ['RoleID' => 'RoleID']);
	    }

	    /**
	    * @return \yii\db\ActiveQuery
	     */
	    public function getUserAccount()
	    {
	        return $this->hasOne(UserAccount::className(), ['UserName' => 'UserName']);
	    }

	}

?>