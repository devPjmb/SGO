<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class Phases extends ActiveRecord
	{
		public $PhaseRoles;
		public $PhaseRolesud;
		public static function tableName()
		{
			return '{{%Phases}}';
		}

		/**
	    * @return \yii\db\ActiveQuery
	     */

		public function rules() {
			return [
				[['Name','Priority'], 'required'],			
				[['Name','Description','UseColor','Icon'], 'string'],
				[['Priority'],'integer', 'integerOnly'=>true],
				[['Priority'],'unique'],
				[['OnlyUser','Notification'],'boolean'],
			];
		}

		public function attributeLabels()
	    {
	        return [
	            'Name' => 'Nombre de la fase',
	            'Description' => 'Descripcion',
	            'Priority' => 'Prioridad de la fase',
	            'OnlyUser' => 'Datos de fase solo por usuarios',
	            'Icon' => 'Icono',
	            'UseColor' => 'Usar color',
	            'Notification' => 'Notificar al completar esta fase',
	            'PhaseRoles' => 'Asignar fase a roles',
	            'PhaseRolesud' => 'Asignar fase a roles'
	            
	        ];
	    }

	    public function getOrderByPhase()
	    {
	        return $this->hasMany(OrderByPhase::className(), ['PhaseID' => 'PhaseID']);
	    }

	    public function getOrderByPhaseInitOne($AccountID = null)
	    {
	    	if($AccountID == null){
	       		 return $this->hasMany(OrderByPhase::className(), ['PhaseID' => 'PhaseID'])->andOnCondition(['Status'=>1]);
	    	}else{
	       		 return $this->hasMany(OrderByPhase::className(), ['PhaseID' => 'PhaseID'])->andOnCondition(['Status'=>1])->andOnCondition("AccountID = $AccountID OR AccountID IS NULL");
	    	}

	    }

	    public function getOrderByPhaseInit($AccountID = null)
	    {
	    	if($AccountID == null){
	       		 return $this->hasMany(OrderByPhase::className(), ['PhaseID' => 'PhaseID'])->andOnCondition(['Status'=>2]);
	    	}else{
	       		 return $this->hasMany(OrderByPhase::className(), ['PhaseID' => 'PhaseID'])->andOnCondition(['Status'=>2])->andOnCondition("AccountID = $AccountID OR AccountID IS NULL");
	    	}
	    }

	    public function getOrderByPhaseStop($AccountID = null)
	    {
	        if($AccountID == null){
	       		 return $this->hasMany(OrderByPhase::className(), ['PhaseID' => 'PhaseID'])->andOnCondition(['Status'=>3]);
	    	}else{
	       		 return $this->hasMany(OrderByPhase::className(), ['PhaseID' => 'PhaseID'])->andOnCondition(['Status'=>3])->andOnCondition("AccountID = $AccountID OR AccountID IS NULL");
	    	}
	    }


	    public function getOrderByPhaseRsvGroup()
	    {
	        return OrderByPhase::find()->select(['DATE(OrderDate) as OrderDate','COUNT(OrderByPhaseID) as Amount'])->where(['PhaseID' => $this->PhaseID])->andWhere(['not', ['OrderDate' => null]])->groupBy(['OrderDate'])->all();
	    }

	    public function getOrderByPhaseRsv()
	    {
	        return OrderByPhase::find()->where(['PhaseID' => $this->PhaseID])->andWhere(['not', ['OrderDate' => null]])->all();
	    }

	    public function getPhaseByRole()
	    {
	        return $this->hasMany(PhaseByRole::className(), ['PhaseID' => 'PhaseID']);
	    }

	    public function getUsersThisPhase()
	    {	
	    	$UsersPhase = [];
	    	//Evitar duplicados
	    	$AccountIDArray = [];
	    	foreach ($this->phaseByRole as $roles) {
	    		foreach ($roles->role->userByRole as $Users) {
	    			if(in_array($Users->userAccount->AccountID, $AccountIDArray))
	    				continue;

    				array_push($UsersPhase, $Users->userAccount);
    				array_push($AccountIDArray, $Users->userAccount->AccountID);
	    		}
	    		
	    	}
	        return $UsersPhase;
	    }

	}

?>