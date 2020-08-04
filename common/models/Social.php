<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class Social extends ActiveRecord
	{
		public static function tableName()
		{
			return '{{%Social}}';
		}

		/**
	    * @return \yii\db\ActiveQuery
	     */

		public function rules() {
			return [
				[['SocialName','Icon','Url'], 'required'],			
				[['SocialName','Url'], 'string','max' => 255],
				[['Icon'], 'string','max' => 55]
			];
		}


	}

?>