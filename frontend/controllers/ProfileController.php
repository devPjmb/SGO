<?php 
	namespace frontend\controllers;

	use Yii;
	use yii\web\Controller;
    use common\components\ValidUsers;

    use yii\helpers\ArrayHelper;
    use yii\web\NotFoundHttpException;
	use yii\web\Response;
	use yii\web\UploadedFile;


    use common\models\Account;
	use common\models\UserAccount;
    use common\models\Country;


	class ProfileController extends Controller
	{
		private $_ValidUser;

		public function actionIndex()
		{	
			$UserData =  Yii::$app->AccessControl->Verify([1,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();
			// $this->layout = "/main";


			$data['ModelAccount'] = $ModelAccount = Account::findOne($UserData->AccountID);

			$data['ModelAgency'] = (empty($ModelAccount->agency))? false : $ModelAccount->agency;

			$data['ModelUserAccount'] = $ModelAccount->userAccount;

			$data['items'] = $items = ArrayHelper::map(Country::find()->all(), 'CountryID', 'Name');


			
			return $this->render('index',$data);	
		}

		public function actionUpdate()
		{
			$dataGlobal =  Yii::$app->AccessControl->Verify([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			
			$ModelAccount = Account::findOne($dataGlobal->AccountID);

			$ModelAgency = (empty($ModelAccount->agency))? false : $ModelAccount->agency;

			$ModelUserAccount = UserAccount::findOne(["AccountID" => $dataGlobal->AccountID]);

			$ModelUserAccountRecived =  $ModelAccount->userAccount;

			if($ModelUserAccountRecived->load(Yii::$app->request->post())){

				$transaction = \Yii::$app->db->beginTransaction();
				$valid = $ModelUserAccountRecived->validate();
				$MessageErros = "";
				if($ModelAgency){
						$ModelAgency->load(Yii::$app->request->post());
						$valid = $ModelAgency->validate() && $valid;
				}
				if($valid){
					$upload = true;
					$agencyCommit = true; 
					try {
						if($ModelUserAccountRecived->UserPassword != $ModelUserAccount->UserPassword && !empty($ModelUserAccountRecived->UserPassword))
							$ModelUserAccountRecived->UserPassword = md5($ModelUserAccountRecived->UserPassword);
						

						
							$ModelUserAccountRecived->PhotoProfile  = UploadedFile::getInstance($ModelUserAccountRecived, 'PhotoProfile');
							if($ModelUserAccountRecived->PhotoProfile != null)
								$upload = $ModelUserAccountRecived->upload();
						
						if($upload){
						 	$commit = $ModelUserAccountRecived->save();
						 }else{ $commit = false; }

							if($ModelAgency)
								 $agencyCommit = $ModelAgency->save();

							if($commit && $agencyCommit){
								$transaction->commit();

		                        Yii::$app->session->setFlash('success', "Actualización de perfil correctamente ");
		                         return $this->redirect(['/profile']);
							}else{
								Yii::$app->session->setFlash('error', "Se ha producido un error al actualizar tu perfil.");
					            $transaction->rollBack();
					            return $this->redirect(['/profile']);
							}
						
					} catch (Exception $e) {
						Yii::$app->session->setFlash('error', "Se ha producido un error al actualizar tu perfil. <br> Mensaje:<br>".$e);
					            $transaction->rollBack();
					            return $this->redirect(['/profile']);
					}
				}else{
					// $MessageErros .= "<br>". var_dump($ModelUserAccountRecived->errors);
					Yii::$app->session->setFlash('error', "Hay una verificación de datos incorrecta, por favor intente de nuevo <br>Mensaje:<br>");
					 $transaction->rollBack();
					return $this->redirect(['/profile']);
				}
				
			}else{
				return $this->redirect(['/profile']);
			}
		}
       
	}