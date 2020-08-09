<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class Clients extends ActiveRecord
	{
		

		public static function tableName()
		{
			return '{{%Clients}}';
		}

		public function rules()
	    {
	        return [
	            [['FullName','Email','Address','Address2','PhoneNumber','Identify'], 'required'],
	            [['FullName',], 'string','max' => 80],
	            [['Address','Address2','Email'], 'string','max' => 128],
	            [['Identify'], 'string','max' => 1],
	            [['PhoneNumber','PhoneNumber2'], 'string'],
	            [['PhoneNumber','PhoneNumber2'],'integer'],
	            [['IDP'],'unique'],
	            [['IDP'],'integer', 'integerOnly'=>true],

	        ];
	    }
	    public function attributeLabels()
	    {
	        return [
	            'FullName' => 'Nombre Completo o Razon Social',
	            'Email' => 'Correo',
	            'Address' => 'Direccion',
	            'Address2' => 'Punto de Referencia',
	            'PhoneNumber' => 'Numero de Teléfono',
	            'PhoneNumber2' => 'Numero de Teléfono 2',
				'IDP' => 'Numero de identificacion',
				'Identify' => 'V o J',
	        ];
	    }

		/**
	 	* @return \yii\db\ActiveQuery
		 */
		public function getOrders()
		{
		    return $this->hasOne(Orders::className(), ['ClientID' => 'ClientID']);
		}
	}

?>