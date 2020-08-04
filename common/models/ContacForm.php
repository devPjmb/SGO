<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;

	class Contact extends ActiveRecord{

		public static function tableName()
    {
        return '{{%Contact}}';
    }



	}