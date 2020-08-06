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

	date_default_timezone_set('America/Caracas');
	

	class OrdersController extends Controller
	{
		private $_valiUser;
        
	////Controlador para la vista del role
        public function actionNew() {
          // echo date("Y-m-d H:m:s"); die();
        	$UserData =  Yii::$app->AccessControl->Verify([1,2,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();
			$data['modelClient'] = new Clients;
			$data['modelOrder'] = new Orders;
			$data['modelphases'] = Phases::find()->OrderBy(['Priority'=>SORT_ASC])->all();

			$data['listClients']  =  ArrayHelper::map(Clients::find()->all(), 'ClientID', function ($data) {
				return "[ ".$data->IDP." ] ".$data->FullName;
			});
			$data['MyDataUser']= $UserData;
			return $this->render('new', $data);
        }
        public function actionGenerate() {
        	$UserData =  Yii::$app->AccessControl->Verify([1,2,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = false;

			$ModelClient = !empty(Yii::$app->request->post('Clients')['ClientID'])? Clients::findOne(Yii::$app->request->post('Clients')['ClientID']) : new Clients;
			$ModelClient->load(Yii::$app->request->post());
			//var_dump($ModelClient);exit();

			$ModelOrder = new Orders;
			$ModelOrder->load(Yii::$app->request->post());
			$deliverydate = date("d-m-y g:i A", strtotime($ModelOrder->DeliveryDate));
			//var_dump($deliverydate);die();
			$ModelOrder->DeliveryDate =	$this->myFdate($ModelOrder->DeliveryDate);
			// var_dump($ModelClient);exit();
			$phone_client = str_replace("+58", "0", $ModelClient->PhoneNumber);
			$total_amount = $ModelOrder->TotalAmount;
			$payment_amount = $ModelOrder->PaymentAmount;
			$remaining_amount = $ModelOrder->RemainingAmount;

			$SelectedPhases = !empty(Yii::$app->request->post('SelectedPhases'))? Yii::$app->request->post('SelectedPhases') : [];
			$ArrayOrders = !empty(Yii::$app->request->post('Orders'))? Yii::$app->request->post('Orders') : [];
			// var_dump(Yii::$app->request->post('SelectedPhases')); exit();
			//echo $ArrayOrders['IDP'];die();
			$transaction = \Yii::$app->db->beginTransaction();

			//echo "<pre>";var_dump($ArrayOrders);echo"</pre>";die();

			try {
				$ModelClient->Identify = $ArrayOrders['Identify'];
				if($ModelClient->validate() && $ModelClient->save()){
					$ModelOrder->AccountID = $UserData->AccountID;
					$ModelOrder->ClientID = $ModelClient->ClientID;
					$ModelOrder->Status = "1";
					$ModelOrder->FileTemp = UploadedFile::getInstance($ModelOrder, 'FileTemp');
					$upload = true;

					if($ModelOrder->FileTemp != null ){
						$upload = $ModelOrder->upload();
					}

					if($ModelOrder->validate() && $ModelOrder->save()){
						$failfase = 0;
						$aux_orders = true;
						foreach ($SelectedPhases as $UsePhases) {
							$ModelOderByPhase = new OrderByPhase;
							$ModelOderByPhase->OrderID = $ModelOrder->OrderID;
							$status = ($aux_orders === true)?"2":"0";
							$dateini = ($aux_orders === true)?date("Y-m-d H:m:s"):NULL;
							$ordernumber = str_pad($ModelOrder->OrderID, 5, '0', STR_PAD_LEFT);
							$ModelOderByPhase->Status = $status;
							$ModelOderByPhase->DateInitial = $dateini;
							$aux_orders = false;
							$ModelOderByPhase->PhaseID = $UsePhases['ID'];
							if(!empty($UsePhases['User'])){ $ModelOderByPhase->AccountID = $UsePhases['User']; }
							if(!$ModelOderByPhase->save()){
								$failfase++;
							}
						}
						if($failfase == 0){
							$transaction->commit();
							$sms_body = "ISLAPIXEL *Orden N ".$ordernumber."* ".$deliverydate." 22/08/19 06:00 PM Total: ".$total_amount.", Abono: ".$payment_amount.", Resta: ".$remaining_amount." Informacion al 04268882241 Gracias por ser nuestro cliente!";
							//var_dump($phone_client.' '.$sms_body);die();
							$this->fSendsms($phone_client,$sms_body);
							Yii::$app->session->setFlash('success', "Orden Generada de forma exitosa.Numero de orden: ".$ordernumber);
							return $this->redirect(['/orders/new']);
						}else{
							$transaction->rollBack();
							Yii::$app->session->setFlash('error', "Fallo generar la orden por conflicto con alguna fase por favor verifique eh intente de nuevo.");
							return $this->redirect(['/orders/new']);
						}
					}else{
						$transaction->rollBack();
						Yii::$app->session->setFlash('error', "Fallo generar la orden por favor verifique los datos eh intente de nuevo.");
							return $this->redirect(['/orders/new']);

					}

				}else{
					$transaction->rollBack();
					Yii::$app->session->setFlash('error', "No se pudo guardar los datos del cliente verifique intente de nuevo.");
						return $this->redirect(['/orders/new']);
				}
			} catch (Exception $e) {
				$transaction->rollBack();
					Yii::$app->session->setFlash('error', "Sucedio un error inesperado intente nuevamente.");
						return $this->redirect(['/orders/new']);
			}

		}
		
		public function actionDeleteorder($id)
		{
			$UserData =  Yii::$app->AccessControl->Verify([1]);
			$this->layout = false;
			$modelOrder = Orders::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($UserData->IsAdminUser == 1){
					if($modelOrder->delete()){
						$transaction->commit();
						Yii::$app->session->setFlash('success', "Order Eliminada");
						$this->redirect(['/orders/my']);
					}else{
						Yii::$app->session->setFlash('error', "No se pudo eliminar la orden.");
						$transaction->rollBack();
						$this->redirect(['/orders/my']);
					}
				}else{
					Yii::$app->session->setFlash('error', "No tiene permisos de eliminar ordenes.");
					$this->redirect(['/orders/my']);
				}
			} catch (\Throwable $th) {
				Yii::$app->session->setFlash('error', "No se pudo eliminar la orden. Error Capturado");
				$transaction->rollBack();
				$this->redirect(['/orders/my']);
			}
		}

        public function actionMy() {
			$UserData =  Yii::$app->AccessControl->Verify([1,2,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();


			if($UserData->TypeUser == 1 || $UserData->TypeUser == 4){
				$sinIniciar = Orders::find()->where(["Status"=>0]);
				$Iniciadas = Orders::find()->where(["Status"=>1]);
				$Completadas = Orders::find()->where(["Status"=>2]);
				$Entregadas = Orders::find()->where(["Status"=>3]);
			}else{
				$sinIniciar = $UserData->account->getOrdersNoStarted();
				$Iniciadas = $UserData->account->getOrdersStarted();
				$Completadas =$UserData->account->getOrdersComplete();
				$Entregadas = $UserData->account->getOrdersDelivered();

			}

			$data['NoStarted']  = new ActiveDataProvider([
			    'query' => $sinIniciar,
			    'pagination' => [
			        'pageSize' => 20,
			    ],
			]);

			$data['Started']  = new ActiveDataProvider([
			    'query' => $Iniciadas,
			    'pagination' => [
			        'pageSize' => 20,
			    ],
			]);

			$data['Complete']  = new ActiveDataProvider([
			    'query' => $Completadas,
			    'pagination' => [
			        'pageSize' => 20,
			    ],
			]);

			$data['Delivered']  = new ActiveDataProvider([
			    'query' => $Entregadas,
			    'pagination' => [
			        'pageSize' => 20,
			    ],
			]);

			return $this->render('my', $data);
        }

        public function actionDataorder(){
        	$order = Orders::findOne($_POST['id']);
        	$data['OrderNumberid'] = $order->OrderID;

        	$data['GenerateOrderby'] =  isset($order->account->agency->FirstName)? $order->account->agency->FirstName. ' ( '.$order->account->userAccount->UserName.' ) ' : ' ( '.$order->account->userAccount->UserName.' ) ';

        	$data['DateDelivered'] = $order->DeliveryDate;
        	$data['NameClient'] = $order->clients->FullName;

        	$data['phoneClient'] = $order->clients->PhoneNumber;

        	$data['Direction'] = '['.$order->clients->Address. '] [' .$order->clients->Address2.']';
        	$data['AmountOrder'] = $order->TotalAmount;
        	$data['AmountPayment'] = $order->PaymentAmount;
        	$data['RemainingOrder'] = $order->RemainingAmount;

        	echo json_encode($data);
        	exit();

        }
        public function actionAddremaining(){
        	// var_dump($_POST);
        	$id = $_POST['IdOrder'];
        	$newabono =$_POST['AddRemaining'];
			$OrderRemaining = Orders::findOne($id);
			
			$abonado = $OrderRemaining->PaymentAmount;
			//var_dump($abonado);die();
        	$TotalAmount = $OrderRemaining->TotalAmount;
        	$Faltante = $OrderRemaining->RemainingAmount;

        	$totalAbonado = $abonado + $newabono;

        	$OrderRemaining->RemainingAmount =  $TotalAmount - $totalAbonado;
        	$OrderRemaining->PaymentAmount = $totalAbonado;

        	if($OrderRemaining->RemainingAmount <= 0){
        		$OrderRemaining->Status = 3;
			}

        	if($OrderRemaining->save(false)){
        		Yii::$app->session->setFlash('success', 'Se agregado correctamente el abono a la orden [ '.$id.' ]');
        		return $this->redirect(['/orders/my']);
        	}else{
        		Yii::$app->session->setFlash('error', 'No se pudo agregar el abono a la orden [ '.$id.' ] intentenuevamente');
        		return $this->redirect(['/orders/my']);
        	}

        	exit();
        }

        public function actionViews($id) {
        	$UserData =  Yii::$app->AccessControl->Verify([1,2,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$data['AccountID'] = $UserData->AccountID;
			$data['OrderID'] = $id;
			$this->layout = $UserData->getLayout();

			$data['OrderData'] = Orders::findOne($id);
			
			//echo "<pre>";var_dump($data['OrderData']);echo "</pre>";die();

			$data['ConfigEventsRange'] =(Object) [	'free' => (Object) ['min'=>0,'max'=>5],
											'medium' => (Object) ['min'=>6,'max'=>10],
											'full'=> (Object) ['min'=>11,'max'=>15]
										] ;


			return $this->render('views', $data);
        }

        public function actionOpa($o,$a) {
        	$UserData =  Yii::$app->AccessControl->Verify([1,2,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = ['status'=>false,'data'=>null];

			$this->layout = false;
			$ConfigEventsRange =(Object) [	'free' => (Object) ['min'=>0,'max'=>5],
											'medium' => (Object) ['min'=>6,'max'=>10],
											'full'=> (Object) ['min'=>11,'max'=>15]
										] ;

			$ObP = OrderByPhase::findOne($o);

			$Phase = Phases::findOne($ObP->PhaseID);
			if($Phase->OnlyUser){
				$OrderData = Orders::findOne($ObP->OrderID);
				$FechaDeEntrega = false;
				if(!empty($ObP->OrderDate)){
					$FechaDeEntrega = ['start'=>$ObP->OrderDate, 'title'=>'Dia de entrega'];
				}
				$SpecificPhase = $OrderData->getOrdersSpecificPhaseAndUserForGroup($ObP->PhaseID,$a);
				$EventsASig = [];
				foreach ($SpecificPhase as $Fases):
                       // echo "[ Fecha: ".$Fases->OrderDate." Cantidad: ".$Fases->Amount."] ";
                        $Var['start'] = $Fases->OrderDate;
                        $Var['title'] = '('.$Fases->Amount.') Entregas Para este dia';
                        switch (true) {
                            case ($Fases->Amount >=  $ConfigEventsRange->free->min && $Fases->Amount <= $ConfigEventsRange->free->max):
                                $Var['color'] = '#257e4a';
                              break;

                            case ($Fases->Amount >=  $ConfigEventsRange->medium->min && $Fases->Amount <= $ConfigEventsRange->medium->max):
                                $Var['color'] = '#ffbd29';
                              break;
                            case ($Fases->Amount >=  $ConfigEventsRange->full->min && $Fases->Amount <= $ConfigEventsRange->full->max):
                                $Var['color'] = '#ff0000';
                              break;
                        }

                        array_push($EventsASig, (Object)$Var);
                endforeach;
                if($FechaDeEntrega){
                	array_push($EventsASig, (Object)$FechaDeEntrega);
                }
                $data['data'] = $EventsASig;
                $data['status'] = true;
			}
			echo json_encode($data);
        }
        private function myFdate($fdate){
        	 $DateDT = new DateTime($fdate);
        	 $AR = explode('T',$DateDT->format(DateTime::ISO8601));
        	 $HR = explode('-', $AR[1]);
        	 if(!isset($HR[1])){
        	 	$HR = explode('+', $AR[1]);
        	 }

        	 $FH = $AR[0].' '.$HR[0];
        	 return $FH;
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
							$OrderDateDT = $this->myFdate((string)$Received->OrderDate);
							$FindPhaseOrder->OrderDate =  $OrderDateDT;
						}
						if(isset($Received->AccountID) && !empty($Received->AccountID)){
							$FindPhaseOrder->AccountID =  $Received->AccountID;
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
										$data_client = $FindPhaseOrder->getClientPhoneByOrder($OrderID);
										$phone_client = str_replace("+58", "0", $data_client[0]['PhoneNumber']);

										// $this->fSendsms($phone_client);

										$FindPhaseOrder->Status = 5;
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
							Yii::$app->session->setFlash('error', $data['Mensaje']);
						}

						if($FindPhaseOrder->Status > 1){
							$countPhasesInitiates++;
						}

					}else{
						if($PhaseOrder->Status >= 4){
							$countPhasesFinis++;
						}
						if($PhaseOrder->Status > 1){
							$countPhasesInitiates++;
						}
						if($flag && $PhaseOrder->Status <= 1){
							$FindPhaseOrder = OrderByPhase::findOne($PhaseOrder->OrderByPhaseID);
							$FindPhaseOrder->Status = 2;
						//	echo "Aqui---> ";print_r($FindPhaseOrder);die();
							$FindPhaseOrder->save();
							$flag = false;
						}//die();
					}
					$countPhases++;
				}
				if($countPhases == $countPhasesFinis){
					$Order->Status = 2;
					$Order->IDP = $Order->OrderID;
					$Order->Identify = 'v';
					if(!$Order->save()){
						$data['Status'] = false;
						$data['Mensaje'] = 'Fallo al especificar que la orden de produccion esta completada';
						Yii::$app->session->setFlash('error', $data['Mensaje']);
					}else{
						$data_client = $FindPhaseOrder->getClientPhoneByOrder($OrderID);
						$phone_client = str_replace("+58", "0", $data_client[0]['PhoneNumber']);
						$ordernumber = str_pad($Order->OrderID, 5, '0', STR_PAD_LEFT);
						$mensaje = 'ISLAPIXEL, su *Orden de Trabajo N '.$ordernumber.'*, esta lista para retirar y/o procesada . Gracias por confiar en nosotros!';
						$this->fSendsms($phone_client, $mensaje);
					}
				}elseif($countPhasesInitiates > 0){
					if($Order->Status == 0 ){
						$Order->Status = 1;
						$Order->IDP = $Order->OrderID;
						$Order->Identify = 'v';
						if(!$Order->save(false)){
							$data['Status'] = false;
							$data['Mensaje'] = 'Fallo al especificar que la orden de produccion esta Iniciada';
							Yii::$app->session->setFlash('error', $data['Mensaje']);
						}
					}
				}
				if($data['Status']){
					$data['Mensaje'] = 'Se actualizo correctamente';
					Yii::$app->session->setFlash('success', $data['Mensaje']);
					$transaction->commit();
				}else{
					$transaction->rollBack();	
				}
			}catch (Exception $e) {
				$data['Status'] = false;
				$data['Mensaje'] = 'Ocurrio un error inesperado';
				Yii::$app->session->setFlash('error', $data['Mensaje']);
				$transaction->rollBack();	
			}	


			echo json_encode($data);
			exit();
        }

        public function fSendsms($pPhone, $pMessage)
        {
        	$user="islapixel"; 
			$password="4HMNC4";
			$url="http://www.interconectados.net/api2/?";

			$textEncode = urlencode($pMessage);

			$parametros="PhoneNumber={$pPhone}&text={$textEncode}&user={$user}&password={$password}";

			$sendUrl = $url.$parametros;

			$handler = curl_init();
			 	curl_setopt($handler, CURLOPT_URL, $sendUrl);
			 	curl_setopt($handler, CURLOPT_HEADER, 0);
			$response = curl_exec ($handler);
        }




   //      public function actionProcessorder() {
   //      	$UserData =  Yii::$app->AccessControl->Verify([1,2,4]);
			// // 1 = Users Admin
			// // 2 = Users moderador
			// // Verificar en tabla TypeUsers
			// $data = [];
			// $this->layout = false;
			// $data['Status'] = true;
			// $OrderProcess =  Yii::$app->request->post('OrderProcess');
			// $OrderID =  Yii::$app->request->post('Order');
			// $OrderProcess = json_decode($OrderProcess);
			// $OrderProcess = (array)$OrderProcess;

			// $Order = Orders::findOne($OrderID);
			// $transaction = \Yii::$app->db->beginTransaction();
			// try{
			// 	$flag = false;
			// 	$countPhases = 0;
			// 	$countPhasesInitiates = 0;
			// 	$countPhasesFinis = 0; 
			// 	foreach ($Order->orderByPhase as $PhaseOrder) {
			// 		if(isset($OrderProcess['index-'.$PhaseOrder->OrderByPhaseID])){
			// 			$Received = $OrderProcess['index-'.$PhaseOrder->OrderByPhaseID];
			// 			$FindPhaseOrder = OrderByPhase::findOne($PhaseOrder->OrderByPhaseID);
			// 			if(isset($Received->OrderDate) && !empty($Received->OrderDate)){
			// 				$OrderDateDT = new DateTime((string)$Received->OrderDate);
			// 				$FindPhaseOrder->OrderDate =  $OrderDateDT->format('Y-m-d H:m:s');
			// 			}

			// 			if($flag){
			// 				$FindPhaseOrder->Status = 1;
			// 			}

			// 			if(isset($Received->Status) && !empty($Received->Status)){

			// 				$FindPhaseOrder->Status = $Received->Status;

			// 				if($Received->Status == 4){
			// 					$countPhasesFinis++;
			// 					$flag = true;
			// 					if($FindPhaseOrder->phases->Notification){
			// 						///Enviar mensaje de que la fase esta terminada;
			// 						//si elenvio de mensaje es correcto pasar Status a 5 $FindPhaseOrder->Status = 5;
			// 					}
			// 				}
			// 			}

			// 			if($FindPhaseOrder->DateInitial == NULL &&  $FindPhaseOrder->Status > 1){
			// 				$FindPhaseOrder->DateInitial = new \yii\db\Expression('NOW()');
			// 			}

			// 			if($FindPhaseOrder->DateFinish == NULL &&  $FindPhaseOrder->Status > 3){
			// 				$FindPhaseOrder->DateFinish = new \yii\db\Expression('NOW()');
			// 			}
			// 			if(!$FindPhaseOrder->save()){
			// 				$data['Status'] = false;
			// 				$data['Mensaje'] = 'Fallo al guardar uno de los cambios especificados en la fase [ '.$FindPhaseOrder->phases->Name.' ]';
			// 			}

			// 			if($FindPhaseOrder->Status > 1){
			// 				$countPhasesInitiates++;
			// 			}

			// 		}else{
			// 			if($PhaseOrder->Status > 4){
			// 				$countPhasesFinis++;
			// 			}
			// 			if($PhaseOrder->Status > 1){
			// 				$countPhasesInitiates++;
			// 			}
			// 		}
			// 		$countPhases++;
			// 	}
			// 	if($countPhases == $countPhasesFinis){
			// 		$Order->Status = 2;
			// 		if(!$Order->save()){
			// 			$data['Status'] = false;
			// 			$data['Mensaje'] = 'Fallo al especificar que la orden de produccion esta completada';
			// 		}
			// 	}elseif($countPhasesInitiates > 0){
			// 		if($Order->Status == 0 ){
			// 			$Order->Status = 1;
			// 			if(!$Order->save()){
			// 				$data['Status'] = false;
			// 				$data['Mensaje'] = 'Fallo al especificar que la orden de produccion esta Iniciada';
			// 			}
			// 		}
			// 	}
			// 	if($data['Status']){
			// 		$data['Mensaje'] = 'Se actualizo correctamente';
			// 		$transaction->commit();
			// 	}else{
			// 		$transaction->rollBack();	
			// 	}
			// }catch (Exception $e) {
			// 	$data['Status'] = false;
			// 	$data['Mensaje'] = 'Ocurrio un error inesperado';
			// 	$transaction->rollBack();	
			// }	


			// echo json_encode($data);
			// exit();
   //      }




    }
?>
