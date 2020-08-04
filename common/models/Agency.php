<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	use common\components\PhoneInput\PhoneInputValidator;
	
	class Agency extends ActiveRecord
	{
		

		public static function tableName()
		{
			return '{{%Agency}}';
		}

		public function rules()
	    {
	        return [
	            [['FirstName','LastName','Country'], 'required'],
	            [['FirstName','LastName','CompanyName'], 'string','max' => 32],
	            [['Address1','Address2'], 'string','max' => 128],
	            [['BusinessPhone','City'], 'string','max' => 16],
	            [['BusinessPhone'],PhoneInputValidator::className()],
	            [['State'], 'string','max' => 32],
	            [['ZipCode','Extension'], 'string','max' => 8],
	            [['CompanyWebSite'], 'string','max' => 256],
	            [['Country'],'integer', 'integerOnly'=>true],

	        ];
	    }
	    public function attributeLabels()
	    {
	        return [
	            'FirstName' => 'Nombre',
	            'LastName' => 'Apellido',
	            'Address1' => 'Direccion 1',
	            'Address2' => 'Direccion 2',
	            'BusinessPhone' => 'Teléfono de negocios',
	            'Extension' => 'Extensión',
	            'CompanyName' => 'Nombre de empresa',
	            'Country' => 'País',
	            'City' => 'Ciudad',
	            'State' => 'Estado',
	            'ZipCode' => 'Código postal',
	            'CompanyWebSite' => 'Página Web de la compañía',
	            
	        ];
	    }

		/**
	 	* @return \yii\db\ActiveQuery
		 */
		public function getAccount()
		{
		    return $this->hasOne(Account::className(), ['AccountID' => 'AccountID']);
		}
	}

?>