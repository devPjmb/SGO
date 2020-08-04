<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class Page extends ActiveRecord
	{
		public static function tableName()
		{
			return '{{%Page}}';
		}
		/**
	     * @inheritdoc
	     */
	    public function rules()
	    {
	        return [
	            
	            [['PageName'], 'string', 'max' => 64],
	            [['PagePath'], 'string', 'max' => 256],
	        ];
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