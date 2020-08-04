<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class MenuByRole extends ActiveRecord
	{
		public static function tableName()
		{
			return '{{%MenuByRole}}';
		}
		/**
	     * @inheritdoc
	     */
	    public function rules()
	    {
	        return [
	            [['RoleID'], 'required'],
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
	    public function getMenu()
	    {
	        return $this->hasOne(Menu::className(), ['MenuID' => 'MenuID']);
	    }
	}

?>