<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class Role extends ActiveRecord
	{
		public static function tableName()
		{
			return '{{%Role}}';
		}

		/**
	    * @return \yii\db\ActiveQuery
	     */

		public function rules() {
			return [
				[['RoleName'], 'required'],			
				[['RoleName'], 'string','max' => 255]
			];
		}

	    public function getUserByRole()
	    {
	        return $this->hasMany(UserByRole::className(), ['RoleID' => 'RoleID']);
	    }

	    /**
	    * @return \yii\db\ActiveQuery
	     */
	    public function getMenuByRole()
	    {
	        return $this->hasMany(MenuByRole::className(), ['RoleID' => 'RoleID']);
	    }

	    public function getPhaseByRole()
	    {
	        return $this->hasMany(PhaseByRole::className(), ['RoleID' => 'RoleID']);
	    }



	}

?>