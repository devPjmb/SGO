<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class PhaseByRole extends ActiveRecord
	{
		public static function tableName()
		{
			return '{{%PhaseByRole}}';
		}
		/**
	     * @inheritdoc
	     */
	    public function rules()
	    {
	        return [
	            [['RoleID','PhaseID'], 'required'],
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
	    public function getPhase()
	    {
	        return $this->hasOne(Phases::className(), ['PhaseID' => 'PhaseID']);
	    }
	}

?>