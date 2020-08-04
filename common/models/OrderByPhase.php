<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class OrderByPhase extends ActiveRecord
	{
		public $FileTemp;
		public $IDP;
		public $Amount;
		public static function tableName()
		{
			return '{{%OrderByPhase}}';
		}

		/**
	    * @return \yii\db\ActiveQuery
	     */

		public function rules() {
			return [
				[['OrderID','PhaseID'], 'required'],
			];
		}

		public function attributeLabels()
	    {
	        return [
	            // 'AccountID' => 'Usuario Encargado',
	            // 'ClientID' => 'Cliente',
	            // 'Description' => 'Descripcion',
	            // 'FileTemp' => 'Archivo adjunto',
	            // 'IDP' => 'Numero de identificacion',
	        ];
	    }


	    public function getOrders()
	    {
	        return $this->hasOne(Orders::className(), ['OrderID' => 'OrderID']);
	    }

	    public function getPhases()
	    {
	        return $this->hasOne(Phases::className(), ['PhaseID' => 'PhaseID']);
	    }

	    public function getAccount()
	    {
	        return $this->hasOne(Account::className(), ['AccountID' => 'AccountID']);
	    }

	    public function getClientPhoneByOrder($orderid)
	    {
	    	return Clients::find()
		    	->from('Clients c')
		    	->innerjoin('Orders o', 'c.ClientID = o.ClientID')
		    	->where(['o.OrderID'=>$orderid])
		    	->all();
	    }

	    public function getAllOrders()
	    {
	    	return $this->hasOne();
	    }


	}

?>