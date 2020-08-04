<?php 
	namespace frontend\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;

	
	class Machines extends ActiveRecord
	{
		use \common\components\RelationTrait;

		public static function tableName()
		{
			return '{{%Machines}}';
		}
		/**
	     * @inheritdoc
	     */
	    public function rules()
	    {
	        return [
	            
	        ];
	    }

	}

?>