<?php 
	namespace backend\controllers;

	use Yii;
	use yii\web\Controller;
	use yii\web\UploadedFile;
    use common\components\ValidUsers;

	use yii\filters\VerbFilter;
    use yii\helpers\ArrayHelper;
	use yii\web\NotFoundHttpException;
	use yii\web\Response;

    use common\models\Model;
    use common\models\TargetsTips;
    use common\models\Tips;
   

    
	use yii\data\ActiveDataProvider;


	class TipsandstyleController extends Controller
	{
		private $_ValidUser;

		public function actionIndex(){
			$this->_ValidUser = new ValidUsers;
			$this->_ValidUser->AccesControl([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = Yii::$app->session->get('UserData');
			$this->layout = $data['LayoutUser'];
			$data['ModelTargetTips']  = $ModelTargetTips = TargetsTips::find();

			$data['dataProvider']  = new ActiveDataProvider([
				    'query' => $ModelTargetTips,
				    'pagination' => [
				        'pageSize' => 20,
				    ],
				]);
			

			// $data['searchModel'] = $searchModel = new Menu();
			// $data['dataProvider'] = $dataProvider = Menu::find()->all();

			return $this->render('index',$data);
		}

		public function actionDelete($id){
			$this->_ValidUser = new ValidUsers;
			$this->_ValidUser->AccesControl([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			// $data = Yii::$app->session->get('UserData');

			$this->layout = false;
			$modelTarget = TargetsTips::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($modelTarget->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Menu delete correctly.");
					$this->redirect(['/tipsandstyle']);
				}else{
					Yii::$app->session->setFlash('error', "There was an error creating the menu.");
					$transaction->rollBack();
					$this->redirect(['/tipsandstyle']);

				}
			} catch (Exception $e) {

				Yii::$app->session->setFlash('error', "There was an error creating the menu.");
				$transaction->rollBack();
				$this->redirect(['/tipsandstyle']);
			}
			
			
		}


		public function actionCreate(){
			$this->_ValidUser = new ValidUsers;
			$this->_ValidUser->AccesControl([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = Yii::$app->session->get('UserData');
			$this->layout = $data['LayoutUser'];


			$TargetsModel = new TargetsTips;
			$TipsModel = [new Tips];
			//$items = ArrayHelper::map(Role::find()->all(), 'RoleID', 'RoleName');

			if($TargetsModel->load(Yii::$app->request->post())){
				//Targets y Tips

				$upload = true;
				$TargetsModel->PhotoTarget = UploadedFile::getInstance($TargetsModel, 'PhotoTarget');
				if($TargetsModel->PhotoTarget != null)
						$upload = $TargetsModel->upload();


				$TipsModel = Model::createMultiple(Tips::classname());
        		Model::loadMultiple($TipsModel, Yii::$app->request->post());
	            $valid = $TargetsModel->validate();
	            $valid = Model::validateMultiple($TipsModel) && $valid;

		            if ($valid) {
		                $transaction = \Yii::$app->db->beginTransaction();

		                try {
		                	if(!$upload){
								Yii::$app->session->setFlash('error', "Fail to upload Image.");
		                        $transaction->rollBack();
		                        $data['TargetsModel'] = $TargetsModel;
			    				$data['TipsModel'] = $TipsModel;
			    				return $this->render('formtips',$data);
							}
		                    if ($flag = $TargetsModel->save(false)){
		                        foreach ($TipsModel as $modelTip) {
		                            $modelTip->TargetsTipsID = $TargetsModel->TargetsTipsID;
		                            if (! ($flag = $modelTip->save(false))){
		                            	Yii::$app->session->setFlash('error', "There was an error creating the menu.");
		                                $transaction->rollBack();
		                                break;
		                            }
		                        }
		                    }

		                    if ($flag){
		                        $transaction->commit();
		                        Yii::$app->session->setFlash('success', "Target and tips created correctly");
		                         return $this->redirect(['/tipsandstyle']);
		                    }
		                } catch (Exception $e) {
		                	Yii::$app->session->setFlash('error', "There was an error creating the Target and tips.");
		                    $transaction->rollBack();
		                }
		            }else{
		            	Yii::$app->session->setFlash('error', "There is an incorrect data verification, please try again");
		            	$data['TargetsModel'] = $TargetsModel;
				    	$data['TipsModel'] = $TipsModel;

		            }
		   	}else{

			    $data['TargetsModel'] = $TargetsModel;
			    $data['TipsModel'] = $TipsModel;

			}
			// ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    Model::validateMultiple($TipsModel),
                    Model::validate($TargetsModel)
                );
            }


			return $this->render('formtips',$data);
		}




		public function actionUpdate($id){
			$this->_ValidUser = new ValidUsers;
			$this->_ValidUser->AccesControl([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = Yii::$app->session->get('UserData');
			$this->layout = $data['LayoutUser'];


			$TargetsModel = TargetsTips::findOne($id);
			$TipsModel = (!empty($TargetsModel->tips))? $TargetsModel->tips : [new Tips] ;

			if($TargetsModel->load(Yii::$app->request->post())){

				$upload = true;
				$TargetsModel->PhotoTarget = UploadedFile::getInstance($TargetsModel, 'PhotoTarget');
				if($TargetsModel->PhotoTarget != null)
						$upload = $TargetsModel->upload();

				//Menu y Subs Menus
				$oldIDs = ArrayHelper::map($TipsModel, 'TipsID', 'TipsID');
				$TipsModel = Model::createMultiple(Tips::classname());
        		Model::loadMultiple($TipsModel, Yii::$app->request->post());
        		$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($TipsModel, 'TipsID', 'TipsID')));
	            $valid = $TargetsModel->validate();
	            $valid = Model::validateMultiple($TipsModel) && $valid;

		            if ($valid) {
		                $transaction = \Yii::$app->db->beginTransaction();

		                try {
		                	if(!$upload){
								Yii::$app->session->setFlash('error', "Fail to upload Image.");
		                        $transaction->rollBack();
		                        $data['TargetsModel'] = $TargetsModel;
			    				$data['TipsModel'] = $TipsModel;
			    				return $this->render('formtips',$data);
							}
		                    if ($flag = $TargetsModel->save(false)){
		                    		if (! empty($deletedIDs)) {
				                            Tips::deleteAll(['TipsID' => $deletedIDs]);
				                        }
		                        foreach ($TipsModel as $modelTips) {
		                            $modelTips->TargetsTipsID = $TargetsModel->TargetsTipsID;
		                            if (! ($flag = $modelTips->save(false))){
		                            	Yii::$app->session->setFlash('error', "There was an error updating the menu.");
		                                $transaction->rollBack();
		                                break;
		                            }
		                        }
		                    }

		                    if ($flag){
		                        $transaction->commit();
		                        Yii::$app->session->setFlash('success', "Target an tips update correctly");
		                         return $this->redirect(['/tipsandstyle']);
		                    }
		                } catch (Exception $e) {
		                	Yii::$app->session->setFlash('error', "There was an error updating target and tips.");
		                    $transaction->rollBack();
		                }
		            }else{
		            	Yii::$app->session->setFlash('error', "There is an incorrect data verification, please try again");
		            	$data['TargetsModel'] = $TargetsModel;
				    	$data['TipsModel'] = $TipsModel;

		            }
			
		   	}else{

			    $data['TargetsModel'] = $TargetsModel;
			    $data['TipsModel'] = $TipsModel;

			}
			// ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    Model::validateMultiple($TipsModel),
                    Model::validate($TargetsModel)
                );
            }


			return $this->render('formtips',$data);
		}



	}