<?php 
	namespace frontend\controllers;
	use Yii;
	use yii\web\Controller;
	use yii\filters\VerbFilter;
	use yii\filters\AccessControl;
    use common\models\Phases;
    use common\models\PhaseByRole;
    use common\models\Clients;
    use common\models\Role;

	use yii\helpers\ArrayHelper;

	use yii\data\ActiveDataProvider;
	use yii\db\Expression;
	

	class SystemController extends Controller
	{
		private $_valiUser;
        
	////Controlador para la vista del role
        public function actionPhases() {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();
			$data['model'] = new Phases;
			$model = Phases::find()->OrderBy(['Priority'=>SORT_ASC]);

			$data['dataProvider']  = new ActiveDataProvider([
			    'query' => $model,
			    'pagination' => [
			        'pageSize' => 20,
			    ],
			]);
			$data['ItemsRole'] = ArrayHelper::map(Role::find()->all(), 'RoleID', 'RoleName');

			return $this->render('phases', $data);
        }
	////Controlador para Crear role
        public function actionSavephase() {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			// $model = new Phases;
			$model =  isset(Yii::$app->request->post('Phases')['PhaseID'])? Phases::findOne(Yii::$app->request->post('Phases')['PhaseID']) : new Phases;
			$model->load(Yii::$app->request->post());
			//$model->save();
				
			$transaction = \Yii::$app->db->beginTransaction();
			//$model->validate();

			if($model->isNewRecord){
				$Roles = isset(Yii::$app->request->post('Phases')['PhaseRoles'])? Yii::$app->request->post('Phases')['PhaseRoles'] : [];
			}else{
				$Roles = isset(Yii::$app->request->post('Phases')['PhaseRolesud'])? Yii::$app->request->post('Phases')['PhaseRolesud'] : [];
					foreach ($model->phaseByRole as $Fases) {
						$Fases->delete();
					}
			}

			if ($model->validate() && $model->save()) {
				foreach ($Roles as $key => $value) {
					$ModelPhaseByRole = new PhaseByRole;
					$ModelPhaseByRole->RoleID = $value;
					$ModelPhaseByRole->PhaseID = $model->PhaseID;
					$ModelPhaseByRole->AuditUser = $UserData->UserName;
					$ModelPhaseByRole->save();
				}
				
				$transaction->commit();
				Yii::$app->session->setFlash('success', "Fase Guardada correctamente.");
				return $this->redirect(['/system/phases']);
			} else{
				$errormss = '';
				foreach ($model->errors as $key => $value) {
					foreach ($value as $k => $d) {
						 	$errormss = $d;
						 	break 2;
					}
				}
				$errormss = str_replace('"', "`", $errormss);
				Yii::$app->session->setFlash('error', "Ocurrio un error al guardar la fase.[ ERROR : ".$errormss."]");
				$transaction->rollBack();
				$this->redirect(['/system/phases']);
			} 	
    	}
	////Controlador para acualizar role
    	public function actionAjaxphase(){
    		$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			$id = $_POST['id'];
			$dataPhase = Phases::findOne($id);
			$data['PhaseID'] = $dataPhase->PhaseID;
			$data['Name'] = $dataPhase->Name;
			$data['Priority'] = $dataPhase->Priority;
			$data['Description'] = $dataPhase->Description;
			$data['UseColor'] = $dataPhase->UseColor;
			$data['OnlyUser'] = $dataPhase->OnlyUser;
			$data['Icon'] = $dataPhase->Icon;
			$data['Notification'] = $dataPhase->Notification;
			$data['Roles'] = array_keys(ArrayHelper::map($dataPhase->phaseByRole, 'RoleID', 'RoleID'));
			echo json_encode($data);
		}

	////Controlador para borrar role
        public function actionDeletephase($id) {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			$id = Phases::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($id->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Fase eliminada correctamente");
					$this->redirect(['/system/phases']);
					
				}else{
					$errormss = '';
					foreach ($model->errors as $key => $value) {
						foreach ($value as $k => $d) {
							 	$errormss = $d;
							 	break 2;
						}
					}
					$errormss = str_replace('"', "`", $errormss);
					Yii::$app->session->setFlash('error', "Ocurrio un error al Eliminar la fase.[ ERROR : ".$errormss."]");
					$transaction->rollBack();
					$this->redirect(['/system/phases']);
				}
			} catch (Exception $e) {
				Yii::$app->session->setFlash('error', "Ocurrioun error.");
				$transaction->rollBack();
				$this->redirect(['/system/phases']);	
			}	
		}





		////Controlador
        public function actionClients() {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();
			$data['model'] = new Clients;
			$model = Clients::find();

			$data['dataProvider']  = new ActiveDataProvider([
			    'query' => $model,
			    'pagination' => [
			        'pageSize' => 20,
			    ],
			]);

			return $this->render('clients', $data);
        }

         public function actionDataclient() {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers

			$data = [];
			$this->layout = $UserData->getLayout();
			$data['model'] = new Clients;
			$data['error'] = false;
			

			$model = (!empty($_POST['id'])) ? Clients::findOne(['ClientID'=>$_POST['id']]) : Clients::findOne(['FullName'=>$_POST['fname']]);

			if ($model == null) {
				echo json_encode(['error'=>true]);
				exit();
			}

			$data['ClientID'] = $model->ClientID;
			$data['FullName'] = $model->FullName;

			$data['Email'] = $model->Email;
			$data['Address'] = $model->Address;
			$data['Address2'] = $model->Address2;

			$data['PhoneNumber'] = $model->PhoneNumber;
			$data['PhoneNumber2'] = $model->PhoneNumber2;
			$data['IDP'] = $model->IDP;
			$data['Identify'] = $model->Identify;


			echo json_encode($data);

		}
	

        public function actionSaveclient() {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			$model =  isset(Yii::$app->request->post('Clients')['ClientID'])? Clients::findOne(Yii::$app->request->post('Clients')['ClientID']) : new Clients;
			//var_dump($model);die();
			$model->load(Yii::$app->request->post());
			//$model->save();
			$transaction = \Yii::$app->db->beginTransaction();
			//$model->validate();
			if ($model->validate() && $model->save()) {
				$transaction->commit();
				Yii::$app->session->setFlash('success', "Cliente Guardado correctamente.");
				return $this->redirect(['/system/clients']);
			} else{
				$errormss = '';
				foreach ($model->errors as $key => $value) {
					foreach ($value as $k => $d) {
						 	$errormss = $d;
						 	break 2;
					}
				}
				$errormss = str_replace('"', "`", $errormss);
				Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el cliente.[ ERROR : ".$errormss."]");
				$transaction->rollBack();
				$this->redirect(['/system/clients']);
			} 	
    	}
       

       public function actionDeleteclient($id) {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			$id = Clients::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($id->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Cliente eliminado correctamente");
					$this->redirect(['/usuario/roles']);
				}else{
					$errormss = '';
					foreach ($model->errors as $key => $value) {
						foreach ($value as $k => $d) {
							 	$errormss = $d;
							 	break 2;
						}
					}
					$errormss = str_replace('"', "`", $errormss);
					Yii::$app->session->setFlash('error', "Ocurrio un error al Eliminar el cliente.[ ERROR : ".$errormss."]");
					$transaction->rollBack();
					$this->redirect(['/system/clients']);
				}
			} catch (Exception $e) {
				Yii::$app->session->setFlash('error', "Ocurrioun error.");
				$transaction->rollBack();
				$this->redirect(['/system/clients']);	
			}	
		}
    }
?>