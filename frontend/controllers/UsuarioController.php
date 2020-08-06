<?php 
	namespace frontend\controllers;
	use Yii;
	use yii\web\Controller;
	use yii\filters\VerbFilter;
	use yii\filters\AccessControl;

	use common\models\Account;
	use common\models\Agency;
	use common\models\UserAccount;
    use common\models\Country;
    use common\models\ValidarUser;
    use common\models\Role;
	use common\models\UserByRole;
	use common\models\TypeUsers;

	use common\components\ValidUsers;
	use yii\helpers\ArrayHelper;

	use yii\data\ActiveDataProvider;
	use yii\db\Expression;
	

	class UsuarioController extends Controller
	{
		private $_valiUser;
        
        //funcion que llama la vista principal de usuarios
        public function actionIndex()
        {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();

            $pAgency = Agency::find();//trae todo de agency de la bd
            $pUserAccount = UserAccount::find()->asArray()->all();//trae Useraccount de l bd	
            $Country = Country::find()->asArray()->all();

            $data['AgencysDat']  = new ActiveDataProvider([
				    'query' => $pAgency,
				    'pagination' => [
				        'pageSize' => 20,
				    ],
				]);   
				
				//echo "<pre>";var_dump($pAgency);echo "</pre>";die();


            $data['Countrys'] = $Country;
            $data['Agencys'] = $pAgency;
            $data['UserAccounts'] = $pUserAccount;
            $data['model'] = new ValidarUser();

            return $this->render('index', $data);
        }

        public function actionDelete($id){
            Yii::$app->session->setFlash('error', "Modulo en mantenimiento, no se pueden eliminar usuarios hasta nuevo aviso!.", "¡ALERTA!");
			$this->redirect(['/usuario']);
		/*	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = false;
			$ModelAccount = Account::findOne($id);
			//var_dump($ModelAccount);die();
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($ModelAccount->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Usuario eliminado de manera correcta.");
					$this->redirect(['/usuario']);
				}else{
					Yii::$app->session->setFlash('error', "Ocurrio un error al eliminar al usuario.");
					$transaction->rollBack();
					$this->redirect(['/usuario']);

				}
			} catch (Exception $e) {

				Yii::$app->session->setFlash('error', "Ocurrio un error al eliminar al usuario.");
				$transaction->rollBack();
				$this->redirect(['/usuario']);
			}*/
			
			
		}

////Controlador para Crear usuarios
        public function actionCreateuser()
        {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();
			
			$data['ModelAccount'] = $ModelAccount = new Account;
			$data['ModelUserAccount'] = $ModelUserAccount = new UserAccount;
			$data['ModelAgency'] = $ModelAgency = new Agency;
			$data['ModelByRole'] = $ModelByRole = new UserByRole;

			$data['ItemsRole'] = ArrayHelper::map(Role::find()->all(), 'RoleID', 'RoleName');
			$data['ItemsCountry'] = ArrayHelper::map(Country::find()->all(), 'CountryID', 'Name');
			$data['aTypeUsers'] = ArrayHelper::map(TypeUsers::find()->all(), 'TypeUsersID', 'Name');

			$transaction = \Yii::$app->db->beginTransaction();
			if(Yii::$app->request->post()){
				$ModelUserAccount->load(Yii::$app->request->post());
				$ModelAgency->load(Yii::$app->request->post());
				$RolesSelecteds = !empty(Yii::$app->request->post('UserByRole'))? Yii::$app->request->post('UserByRole') : ['RoleID'=>[]];
				$valid = $ModelUserAccount->validate();
				$valid = $ModelAgency->validate() && $valid;
				// $valid = $ModelByRole->validate() && $valid;

				if($valid){
					try {
						$ModelAccount->IsActive = 1;
						$ModelAccount->AuditDate = new Expression('NOW()');
						$ModelAccount->AuditUser = "System";

						if(!$ModelAccount->save()){
							Yii::$app->session->setFlash('error', "Ha ocurrido un error en la creacion del usuario.");
					        $transaction->rollBack();

					        echo "create Account";
					        exit();
						}

						$ModelUserAccount->AccountID = $ModelAccount->AccountID;
						$ModelUserAccount->UserPassword = md5($ModelUserAccount->UserPassword);
						if(!$ModelUserAccount->save()){
							Yii::$app->session->setFlash('error', "Ha ocurrido un error en la creacion del usuario.");
					        $transaction->rollBack();
					        echo "create UserAccount";
					        exit();
						}


						$ModelAgency->AccountID = $ModelAccount->AccountID;

						if(!$ModelAgency->save()){
							Yii::$app->session->setFlash('error', "Ha ocurrido un error en la creacion del usuario.");
					        $transaction->rollBack();
					        echo "create Agency";
					        exit();
						}

						foreach ($RolesSelecteds['RoleID'] as $key => $value):
							$ModelByRole->UserName = $ModelUserAccount->UserName;
							$ModelByRole->RoleID = $value;
							$ModelByRole->AuditUser = $UserData->UserName;
							$ModelByRole->AuditDate = date('Y-m-d H:m:s');
							$ModelByRole->IsActive = 1;

							if(!$ModelByRole->validate() || !$ModelByRole->save()){
								Yii::$app->session->setFlash('error', "Ha ocurrido un error en la creacion del usuario.");
						        $transaction->rollBack();
						        echo "UserByRole";
						        exit();
							}
							$ModelByRole = new UserByRole;
						endforeach;
						$ModelByRole->RoleID = $RolesSelecteds['RoleID'];

						Yii::$app->session->setFlash('success', "Usuario creado correctamente");
						$transaction->commit();
						return $this->redirect(['/usuario']);

					} catch (Exception $e) {
						Yii::$app->session->setFlash('error', "Ha ocurrido un error en la creacion del usuario.");
					        $transaction->rollBack();
					        $data['ModelAccount'] = $ModelAccount;
							$data['ModelUserAccount'] = $ModelUserAccount;
							$data['ModelAgency'] = $ModelAgency;
							$data['ModelByRole'] = $ModelByRole;
						
					}
				}else{
					Yii::$app->session->setFlash('error', "Los datos ingresados son incorrectos. Porfavor verifiqueeh intente de nuevo");
					// $data['ModelAccount'] = $ModelAccount = new Account;
					// $data['ModelUserAccount'] = $ModelUserAccount = new UserAccount;
					// $data['ModelAgency'] = $ModelAgency = new Agency;
					// $data['ModelByRole'] = $ModelByRole = new UserByRole;

					$data['ModelAccount'] = $ModelAccount;
					$data['ModelUserAccount'] = $ModelUserAccount;
					$data['ModelAgency'] = $ModelAgency;
					$data['ModelByRole'] = $ModelByRole;
				 }
			}



            return $this->render('userform', $data);
        }


//Controlador para Actualizar datos de usuario
        public function actionUpdate($id)
        {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();
			
			$ModelFindUserAccount = UserAccount::findOne(['AccountID' => $id]);

			$ModelAccount = Account::findOne($id);
			$ModelAccount->isNewRecord = false;
			$data['ModelAccount'] = $ModelAccount;
			$data['ModelUserAccount'] = $ModelUserAccount = $ModelAccount->userAccount;
			$data['ModelAgency'] = $ModelAgency = $ModelAccount->agency;

			$ModelByRole = new UserByRole;
			$ModelByRole->RoleID =  ArrayHelper::map($ModelAccount->userAccount->userByRole,'RoleID','RoleID');
			// var_dump($ModelByRole->RoleID); exit();
			$data['ModelByRole'] = $ModelByRole;
			// $roles = [];
			// array_push($roles,$ModelAccount->userAccount->userByRole->RoleID);

			// $data['ItemsRoleUse'] = $roles;
			$data['ItemsRole'] = ArrayHelper::map(Role::find()->all(), 'RoleID', 'RoleName');
			$data['ItemsCountry'] = ArrayHelper::map(Country::find()->all(), 'CountryID', 'Name');
			$data['aTypeUsers'] = ArrayHelper::map(TypeUsers::find()->all(), 'TypeUsersID', 'Name');

			$transaction = \Yii::$app->db->beginTransaction();
			if(Yii::$app->request->post()){
				$ModelUserAccount->load(Yii::$app->request->post());
				$ModelAgency->load(Yii::$app->request->post());
				//$ModelByRole->load(Yii::$app->request->post());
				//$RolesSelecteds = Yii::$app->request->post('UserByRole');
				$RolesSelecteds = !empty(Yii::$app->request->post('UserByRole'))? Yii::$app->request->post('UserByRole') : ['RoleID'=>[]];

				$valid = $ModelUserAccount->validate();
				$valid = $ModelAgency->validate() && $valid;
				//$valid = $ModelByRole->validate() && $valid;

				if($valid){
					try {
						$ModelAccount->IsActive = 1;
						$ModelAccount->AuditDate = new Expression('NOW()');
						$ModelAccount->AuditUser = "System";

						if(!$ModelAccount->save()){
							Yii::$app->session->setFlash('error', "Ha ocurrido un error en la creacion del usuario.");
					        $transaction->rollBack();

					        echo "create Account";
					        exit();
						}

						$ModelUserAccount->AccountID = $ModelAccount->AccountID;
						if($ModelUserAccount->UserPassword != $ModelFindUserAccount->UserPassword && !empty($ModelUserAccount->UserPassword )){
							$ModelUserAccount->UserPassword = md5($ModelUserAccount->UserPassword);
						}else{ $ModelUserAccount->UserPassword = $ModelFindUserAccount->UserPassword; }
						if(!$ModelUserAccount->save()){
							Yii::$app->session->setFlash('error', "Ha ocurrido un error en la creacion del usuario.");
					        $transaction->rollBack();
					        echo "create UserAccount";
					        exit();
						}


						$ModelAgency->AccountID = $ModelAccount->AccountID;

						if(!$ModelAgency->save()){
							Yii::$app->session->setFlash('error', "Ha ocurrido un error en la creacion del usuario.");
					        $transaction->rollBack();
					        echo "create Agency";
					        exit();
						}
						foreach($ModelAccount->userAccount->userByRole as $model):
							$model->delete();
						endforeach;
						foreach ($RolesSelecteds['RoleID'] as $key => $value):
								$ModelByRole->UserName = $ModelUserAccount->UserName;
								$ModelByRole->RoleID = $value;
								$ModelByRole->AuditUser = $UserData->UserName;
								$ModelByRole->AuditDate = date('Y-m-d H:m:s');
								$ModelByRole->IsActive = 1;

							if(!$ModelByRole->validate() || !$ModelByRole->save()){
								Yii::$app->session->setFlash('error', "Ha ocurrido un error en la creacion del usuario.");
						        $transaction->rollBack();
						        echo "UserByRole";
						        exit();
							}
							$ModelByRole = new UserByRole;
						endforeach;
						$ModelByRole->RoleID = $RolesSelecteds['RoleID'];

						// $ModelByRole->UserName = $ModelUserAccount->UserName;
						// // var_dump($ModelByRole->RoleID);exit();
						// if(!$ModelByRole->save()){
						// 	Yii::$app->session->setFlash('error', "Ha ocurrido un error en la creacion del usuario.");
					 //        $transaction->rollBack();
					 //        echo "UserByRole";
					 //        exit();
						// }

						Yii::$app->session->setFlash('success', "Usuario actualizado correctamente.");
						$transaction->commit();
						return $this->redirect(['/usuario']);

					} catch (Exception $e) {
						Yii::$app->session->setFlash('error', "Ha ocurrido un error en la creacion del usuario.");
					        $transaction->rollBack();
					        $data['ModelAccount'] = $ModelAccount;
							$data['ModelUserAccount'] = $ModelUserAccount;
							$data['ModelAgency'] = $ModelAgency;
							$data['ModelByRole'] = $ModelByRole;
						
					}
				}else{
					Yii::$app->session->setFlash('error', "Los datos ingresados son incorrectos. Porfavor verifiqueeh intente de nuevo");
					$data['ModelAccount'] = $ModelAccount = new Account;
					$data['ModelUserAccount'] = $ModelUserAccount = new UserAccount;
					$data['ModelAgency'] = $ModelAgency = new Agency;
					$data['ModelByRole'] = $ModelByRole = new UserByRole;
				}
			}



            return $this->render('userform', $data);
        }

////Controlador para la vista del role
        public function actionRoles() {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();
			$data['model'] = new Role;
			$model = Role::find();

			$data['dataProvider']  = new ActiveDataProvider([
			    'query' => $model,
			    'pagination' => [
			        'pageSize' => 20,
			    ],
			]);

			return $this->render('roles', $data);
        }
////Controlador para Crear role
        public function actionCreaterole() {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			$model = new Role;
			$model->RoleName = $_POST['Role']['RoleName'];
			//$model->save();
				
			$transaction = \Yii::$app->db->beginTransaction();
			$model->validate();
			if ($model->save()) {
				$transaction->commit();
				Yii::$app->session->setFlash('success', "Role create correctly.");
				return $this->redirect(['/usuario/roles']);
			} else{
				Yii::$app->session->setFlash('error', "There was an error while saving the role.");
				$transaction->rollBack();
				$this->redirect(['/usuario/roles']);
			} 	
    }
////Controlador para acualizar role
    	public function actionAjaxrole(){
    		$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			$id = $_POST['id'];
			$dataRole = Role::findOne($id);
			$data['RoleID'] = $dataRole->RoleID;
			$data['RoleName'] = $dataRole->RoleName;
			echo json_encode($data);
		}

        public function actionUpdaterole() {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
        	$model = Role::findOne($_POST['Role']['RoleID']);

			$transaction = \Yii::$app->db->beginTransaction();
			if($model->load(Yii::$app->request->post())) {
				$model->validate();
				if ($model->save()) {
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Role update correctly.");
					return $this->redirect(['/usuario/roles']);
				} else{
					Yii::$app->session->setFlash('error', "There was an error while saving the role.");
					$transaction->rollBack();
					$this->redirect(['/updaterole/'.$id]);
				} 	
			}
        }

////Controlador para borrar role
        public function actionDeleterole($id) {
        	$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			$id = Role::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($id->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Role delete correctly.");
					$this->redirect(['/usuario/roles']);
				}else{
					Yii::$app->session->setFlash('error', "There was an error.");
					$transaction->rollBack();
					$this->redirect(['/usuario/roles']);
				}
			} catch (Exception $e) {
				Yii::$app->session->setFlash('error', "There was an error.");
				$transaction->rollBack();
				$this->redirect(['/usuario/roles']);	
			}	
		}
       
    }
?>