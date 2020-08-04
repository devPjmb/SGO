<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class Tips extends ActiveRecord
	{
		public static function tableName()
		{
			return '{{%Tips}}';
		}
		/**
	     * @inheritdoc
	     */
	    public function rules()
	    {
	        return [
	            
	            [['Content'], 'required'],
	            [['Content'], 'string', 'max' => 255],
	        ];
	    }

		/**
	    * @return \yii\db\ActiveQuery
	     */
	    public function getTargetsTips()
	    {
	        return $this->hasOne(TargetsTips::className(), ['TargetsTipsID' => 'TargetsTipsID']);
	    }

	}

?>