<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class Orders extends ActiveRecord
	{
		public $FileTemp;
		public $IDP;
		public $Identify;
		public static function tableName()
		{
			return '{{%Orders}}';
		}

		/**
	    * @return \yii\db\ActiveQuery
	     */

		public function rules() {
			return [
				[['AccountID','ClientID','DeliveryDate','TotalAmount','RemainingAmount','PaymentAmount','Identify','IDP'], 'required'],			
				[['Description','File','DeliveryDate'], 'string'],
				[['Identify'], 'string','max' => 1],
				[['AccountID','ClientID', 'IDP','Status'],'integer', 'integerOnly'=>true],
				[['FileTemp'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, pdf, doc, rar, zip, psd, docx'],
			];
		}

		public function attributeLabels()
	    {
	        return [
	            'AccountID' => 'Usuario Encargado',
	            'ClientID' => 'Cliente',
	            'Description' => 'Descripcion',
	            'FileTemp' => 'Archivo adjunto',
	            'IDP' => 'Numero de identificacion',
	            'DateCreate' => "Fecha de Generacion",
	            'DeliveryDate' => "Fecha de entrega",
	            'TotalAmount' => 'Monto Total',
	            'RemainingAmount' => 'Monto Restante',
				'PaymentAmount' => "Monto Abonado",
				'Identify' => 'V o J',
	        ];
	    }
	    /*public function upload(){

	        if ($this->validate()){
	            $this->File = $this->FileTemp->baseName . "_". substr(md5(uniqid(rand())),0,6) . '.' . $this->FileTemp->extension;
	            $pathdir = Yii::$app->basePath.'/../Files/'.$this->ClientID.'/';
	            if (!file_exists($pathdir)) {
					   mkdir($pathdir, 0777);
					}

				if (file_exists($pathdir)) {
			            $this->FileTemp->saveAs($pathdir.$this->File);
			            $this->FileTemp = null;
			            return true;
					}

	            return false;
	        } else {
	            return false;
	        }
	    }*/

	    public function getOrderByPhase()
	    {
	        return $this->hasMany(OrderByPhase::className(), ['OrderID' => 'OrderID'])->select(['OrderByPhase.*','Phases.Priority'])->innerjoin('Phases')->where('OrderByPhase.PhaseID = Phases.PhaseID')->orderBy(['Priority'=>SORT_ASC]);
	    }

	    public function getClients()
	    {
	        return $this->hasOne(Clients::className(), ['ClientID' => 'ClientID']);
	    }

	    public function getAccount()
	    {
	        return $this->hasOne(Account::className(), ['AccountID' => 'AccountID']);
		}
		
		public function getUserAccount()
		{
			return $this->hasOne(UserAccount::className(), ['AccountID' => 'AccountID']);
		}

	    public function getOrdersSpecificPhaseAndUser($phase,$AccountID){

	        return OrderByPhase::find()->where(['not', ['OrderDate' => null]])->andwhere(['AccountID'=>$AccountID])->andwhere(['PhaseID' => $phase])->all();
	    }

	    public function getOrdersSpecificPhaseAndUserForGroup($phase,$AccountID){

	        return OrderByPhase::find()->select(['DATE(OrderDate) as OrderDate','COUNT(OrderByPhaseID) as Amount'])->where(['not', ['OrderDate' => null]])->andwhere(['AccountID'=>$AccountID])->andwhere(['PhaseID' => $phase])->groupBy(['OrderDate'])->all();
	    }

	    public function getTotalOrdersNotComplete($AccountID)
	    {
	    	return OrderByPhase::find()->select(['COUNT(*) As TotalOrdersNotComplete'])->where(['AccountID'=>$AccountID])->andwhere(['Status' => '4'])->all();
	    }
	}

?>