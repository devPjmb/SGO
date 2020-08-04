<?php 
	namespace frontend\controllers;
	use Yii;
	use yii\web\Controller;
	use yii\filters\VerbFilter;
	use yii\filters\AccessControl;
    use common\models\Phases;
    use common\models\Clients;
    use common\models\Orders;
    use common\models\OrderByPhase;
    use yii\web\UploadedFile;
    use DateTime;


	use yii\helpers\ArrayHelper;

	use yii\data\ActiveDataProvider;
	use yii\data\BaseDataProvider;
	use yii\db\Expression;
	

	class JobsController extends Controller
	{
		private $_valiUser;
        
	////Controlador para la vista del role
        public function actionIndex() {
        	$UserData =  Yii::$app->AccessControl->Verify([1,2,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();

			$MyPhases = [];
			//No repeat Phases
			$IDphases = [];
			foreach ($UserData->userByRole as $mRoles) {
				if(!empty($mRoles->role->phaseByRole)){
					foreach ($mRoles->role->phaseByRole as $byPhase) {
						$tempPhase =  $byPhase->phase;
						if(in_array($tempPhase->PhaseID, $IDphases))
							continue;

						array_push($MyPhases, $tempPhase);
						array_push($IDphases, $tempPhase->PhaseID);
					}

				}
				
			}

			$data['MyPhases'] = $MyPhases;
			$Events = [];
			foreach ($MyPhases as $Phase):
				if($UserData->TypeUser = 4){
		        	$NoInitPhases = $Phase->getOrderByPhaseInitOne()->all();
		        	$InitPhases = $Phase->getOrderByPhaseInit()->all();
		        	$StopPhases = $Phase->getOrderByPhaseStop()->all();
		        }
				elseif($Phase->OnlyUser){
		        	$NoInitPhases = $Phase->getOrderByPhaseInitOne($UserData->AccountID)->all();
		        	$InitPhases = $Phase->getOrderByPhaseInit($UserData->AccountID)->all();
		        	$StopPhases = $Phase->getOrderByPhaseStop($UserData->AccountID)->all();
		        }else{
		        	$NoInitPhases = $Phase->getOrderByPhaseInitOne()->all();
		        	$InitPhases = $Phase->getOrderByPhaseInit()->all();
		        	$StopPhases = $Phase->getOrderByPhaseStop()->all();
		        }
		        foreach ($NoInitPhases as $NIphase) {
		        	// var_dump($NIphase);exit();
		        	$EvNI = [];
		        	$EvNI['start'] = !empty($NIphase->OrderDate)? $NIphase->OrderDate : $NIphase->orders->DeliveryDate;
		        	$EvNI['title'] = "Orden [{$NIphase->OrderID}] Sin Iniciar";
		        	$EvNI['color'] =  $Phase->UseColor;
		        	$EvNI['url'] = Yii::getAlias('@web')."/jobs/views/".$NIphase->OrderByPhaseID;
		        	array_push($Events, (Object)$EvNI);
		        }
		        $i =1;
		        foreach ($InitPhases as $Iphase) {

		        	if(empty($Iphase->orders)){
		        		continue;
		        	}

		        	$EvI = [];
		        	$EvI['start'] = !empty($Iphase->OrderDate)? $Iphase->OrderDate : $Iphase->orders->DeliveryDate;
		        	$EvI['title'] = "Orden [{$Iphase->OrderID}] Iniciada sin terminar";
		        	$EvI['color'] =  $Phase->UseColor;
		        	$EvI['url'] = Yii::getAlias('@web')."/jobs/views/".$Iphase->OrderByPhaseID;
		        	array_push($Events, (Object)$EvI);
		        }

		        foreach ($StopPhases as $Sphase) {
		        	$EvS = [];
		        	$EvS['start'] = !empty($Sphase->OrderDate)? $Sphase->OrderDate : $Sphase->orders->DeliveryDate;
		        	$EvS['title'] = "Orden [{$Sphase->OrderID}] Detenida";
		        	$EvS['color'] =  $Phase->UseColor;
		        	$EvS['url'] = Yii::getAlias('@web')."/jobs/views/".$Sphase->OrderByPhaseID;
		        	array_push($Events, (Object)$EvS);
		        }

		    endforeach;

		    $data['Events'] = $Events;

			return $this->render('index', $data);
        }


        public function actionPhase($id) {
        	$UserData =  Yii::$app->AccessControl->Verify([1,2,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();
			$Phase = Phases::findOne($id);
			if(empty($Phase)){ return $this->redirect(['/jobs']); }

			$ModelUsersThisPhase = $Phase->usersThisPhase;

			$UsersThisPhaseList = ArrayHelper::map(
	                            $ModelUsersThisPhase,
	                            'AccountID',
	                            function($model){
	                            if(!empty($model->account->agency)){
	                                return "[". $model->UserName . "]" . $model->account->agency->FirstName . " " . $model->account->agency->LastName;
	                            }else{
	                                return $model->UserName ;
	                            }
	                        });

	        $UsersAccountsID = array_keys($UsersThisPhaseList);
	        if(!in_array($UserData->AccountID,$UsersAccountsID)){
	        	return $this->redirect(['/jobs']);
	        }

	        if($Phase->OnlyUser){
	        	$NoInitPhases = $Phase->getOrderByPhaseInitOne($UserData->AccountID);
	        	$InitPhases = $Phase->getOrderByPhaseInit($UserData->AccountID);
	        	$StopPhases = $Phase->getOrderByPhaseStop($UserData->AccountID);
	        }else{
	        	$NoInitPhases = $Phase->getOrderByPhaseInitOne();
	        	$InitPhases = $Phase->getOrderByPhaseInit();
	        	$StopPhases = $Phase->getOrderByPhaseStop();
	        }

	        $data['NoInitPhases']  = new ActiveDataProvider([
				    'query' => $NoInitPhases,
				    'pagination' => [
				        'pageSize' => 20,
				    ],
				]); 

	        $data['InitPhases']  = new ActiveDataProvider([
				    'query' => $InitPhases,
				    'pagination' => [
				        'pageSize' => 20,
				    ],
				]);

	        $data['StopPhases']  = new ActiveDataProvider([
				    'query' => $StopPhases,
				    'pagination' => [
				        'pageSize' => 20,
				    ],
				]);



			return $this->render('phase', $data);
        }

        public function actionViews($id) {
        	$UserData =  Yii::$app->AccessControl->Verify([1,2,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();
			$data['OrderByPhase'] = $RegOrder = OrderByPhase::findOne($id);

			if(empty($RegOrder)){ return $this->redirect(['/jobs']); }

			$data['OrderData'] = $RegOrder->orders;
			$data['AccountID'] = $UserData->AccountID;
			$data['Phase'] = $RegOrder->phases;

			return $this->render('views', $data);
        }


        public function actionProcessorder() {
        	$UserData =  Yii::$app->AccessControl->Verify([1,2,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = false;
			$data['Status'] = true;
			$OrderProcess =  Yii::$app->request->post('OrderProcess');
			$OrderID =  Yii::$app->request->post('Order');
			$OrderProcess = json_decode($OrderProcess);
			$OrderProcess = (array)$OrderProcess;

			$Order = Orders::findOne($OrderID);
			$transaction = \Yii::$app->db->beginTransaction();
			try{
				$flag = false;
				$countPhases = 0;
				$countPhasesInitiates = 0;
				$countPhasesFinis = 0; 
				foreach ($Order->orderByPhase as $PhaseOrder) {
					if(isset($OrderProcess['index-'.$PhaseOrder->OrderByPhaseID])){
						$Received = $OrderProcess['index-'.$PhaseOrder->OrderByPhaseID];
						$FindPhaseOrder = OrderByPhase::findOne($PhaseOrder->OrderByPhaseID);
						if(isset($Received->OrderDate) && !empty($Received->OrderDate)){
							$OrderDateDT = new DateTime((string)$Received->OrderDate);
							$FindPhaseOrder->OrderDate =  $OrderDateDT->format('Y-m-d H:m:s');
						}


						if($flag){
							$FindPhaseOrder->Status = 1;
						}
						if(isset($Received->Status)){
							if($Received->Status != ''){
								$FindPhaseOrder->Status = $Received->Status;

								if($Received->Status == 4){
									$countPhasesFinis++;
									$flag = true;
									if($FindPhaseOrder->phases->Notification){
										///Enviar mensaje de que la fase esta terminada;
										//si elenvio de mensaje es correcto pasar Status a 5 $FindPhaseOrder->Status = 5;
									}
								}
								if($Received->Status > 1 && !$FindPhaseOrder->AccountID){
									$FindPhaseOrder->AccountID = $UserData->AccountID;
								}
							}
						}

						if($FindPhaseOrder->DateInitial == NULL &&  $FindPhaseOrder->Status > 1){
							$FindPhaseOrder->DateInitial = new \yii\db\Expression('NOW()');
						}

						if($FindPhaseOrder->DateFinish == NULL &&  $FindPhaseOrder->Status > 3){
							$FindPhaseOrder->DateFinish = new \yii\db\Expression('NOW()');
						}
						if(!$FindPhaseOrder->save()){
							$data['Status'] = false;
							$data['Mensaje'] = 'Fallo al guardar uno de los cambios especificados en la fase [ '.$FindPhaseOrder->phases->Name.' ]';
						}

						if($FindPhaseOrder->Status > 1){
							$countPhasesInitiates++;
						}

					}else{
						if($PhaseOrder->Status > 4){
							$countPhasesFinis++;
						}
						if($PhaseOrder->Status > 1){
							$countPhasesInitiates++;
						}
					}
					$countPhases++;
				}
				if($countPhases == $countPhasesFinis){
					$Order->Status = 2;
					if(!$Order->save()){
						$data['Status'] = false;
						$data['Mensaje'] = 'Fallo al especificar que la orden de produccion esta completada';
					}
				}elseif($countPhasesInitiates > 0){
					if($Order->Status == 0 ){
						$Order->Status = 1;
						if(!$Order->save()){
							$data['Status'] = false;
							$data['Mensaje'] = 'Fallo al especificar que la orden de produccion esta Iniciada';
						}
					}
				}
				if($data['Status']){
					$data['Mensaje'] = 'Se actualizo correctamente';
					$transaction->commit();
				}else{
					$transaction->rollBack();	
				}
			}catch (Exception $e) {
				$data['Status'] = false;
				$data['Mensaje'] = 'Ocurrio un error inesperado';
				$transaction->rollBack();	
			}	


			echo json_encode($data);
			exit();
        }

    }
?>