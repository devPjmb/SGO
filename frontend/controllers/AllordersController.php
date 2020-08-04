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
    use DateTime;


	use yii\helpers\ArrayHelper;

	use yii\data\ActiveDataProvider;
	use yii\data\BaseDataProvider;
	use yii\db\Expression;

	class AllordersController extends Controller
	{
		private $_valiUser;

		public function actionIndex()
		{
			$UserData =  Yii::$app->AccessControl->Verify([1,2,4]);
			$data = [];
			$this->layout = $UserData->getLayout();
			$MyPhases = [];
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
			$DataArrayOrders = [];
			//$DataAllOrders = OrderByPhase::find()->all();

			foreach ($MyPhases as $Phase):
				
		        	$NoInitPhases = $Phase->getOrderByPhaseInitOne()->all();
		        	$InitPhases = $Phase->getOrderByPhaseInit()->all();
		        	$StopPhases = $Phase->getOrderByPhaseStop()->all();
		        
		        foreach ($NoInitPhases as $NIphase) {
		        	$EvNI = [];
		        	$EvNI['start'] = !empty($NIphase->OrderDate)? $NIphase->OrderDate : $NIphase->orders->DeliveryDate;
		        	$EvNI['title'] = "Orden [{$NIphase->OrderID}] Sin Iniciar - En la fase [{$Phase->Name}]";
		        	$EvNI['color'] =  $Phase->UseColor;
		        	$EvNI['url'] = Yii::getAlias('@web')."/jobs/views/".$NIphase->OrderByPhaseID;
		        	array_push($DataArrayOrders, (Object)$EvNI);
		        }

		        foreach ($InitPhases as $Iphase) {
		        	$EvI['start'] = !empty($Iphase->OrderDate)? $Iphase->OrderDate : "$Iphase->orders->DeliveryDate";
		        	$EvI['title'] = "Orden [{$Iphase->OrderID}] Iniciada sin terminar - En la fase [{$Phase->Name}]";
		        	$EvI['color'] =  $Phase->UseColor;
		        	$EvI['url'] = Yii::getAlias('@web')."/jobs/views/".$Iphase->OrderByPhaseID;
		        	array_push($DataArrayOrders, (Object)$EvI);
		        	//var_dump($EvI);
		        }//die();

		        foreach ($StopPhases as $Sphase) {
		        	$EvS = [];
		        	$EvS['start'] = !empty($Sphase->OrderDate)? $Sphase->OrderDate : $Sphase->orders->DeliveryDate;
		        	$EvS['title'] = "Orden [{$Sphase->OrderID}] Detenida - En la fase [{$Phase->Name}]";
		        	$EvS['color'] =  $Phase->UseColor;
		        	$EvS['url'] = Yii::getAlias('@web')."/jobs/views/".$Sphase->OrderByPhaseID;
		        	array_push($DataArrayOrders, (Object)$EvS);
		        }
		    endforeach;

$data['DataArrayOrders'] = $DataArrayOrders;








			/*foreach($DataAllOrders as $aux):
				$ArrayOrders = [];
				$ArrayOrders['start'] = $aux->DateInitial;
				$ArrayOrders['title'] = 'Orden ['.$aux->OrderID.']';
				array_push($DataArrayOrders, (Object)$ArrayOrders);
			endforeach;
			$data['DataArrayOrders'] = $DataArrayOrders;*/
			//var_dump($DataArrayOrders);die();
			return $this->render('index', $data);
		}
	}