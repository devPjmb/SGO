<?php 
	namespace backend\controllers;

	use Yii;
	use yii\web\Controller;
    use common\components\ValidUsers;

	use yii\filters\VerbFilter;
    use yii\helpers\ArrayHelper;
	use yii\web\NotFoundHttpException;
	use yii\web\Response;

    // use common\models\Menu;
    use common\models\Model;
    use common\models\MenuByRole;
    use common\models\Menu;
    use common\models\Page;
    use common\models\Role;

    
	use yii\data\ActiveDataProvider;


	class MenuController extends Controller
	{
		private $_ValidUser;

		public function actionIndex(){
			$this->_ValidUser = new ValidUsers;
			$this->_ValidUser->AccesControl([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = Yii::$app->session->get('UserData');
			$this->layout = $data['LayoutUser'];
			$data['ModelMenu']  = $modelMenu = Menu::find();

			$data['dataProvider']  = new ActiveDataProvider([
				    'query' => $modelMenu,
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
			$modelMenu = Menu::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($modelMenu->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Menu delete correctly.");
					$this->redirect(['/menu']);
				}else{
					Yii::$app->session->setFlash('error', "There was an error creating the menu.");
					$transaction->rollBack();
					$this->redirect(['/menu']);

				}
			} catch (Exception $e) {

				Yii::$app->session->setFlash('error', "There was an error creating the menu.");
				$transaction->rollBack();
				$this->redirect(['/menu']);
			}
			
			
		}


		public function actionCreatemenu(){
			$this->_ValidUser = new ValidUsers;
			$this->_ValidUser->AccesControl([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = Yii::$app->session->get('UserData');
			$this->layout = $data['LayoutUser'];


			$MenuModel = new Menu;
			$PagesModel = [new Page];
			$ModelsMenuByRole = new MenuByRole;
			$items = ArrayHelper::map(Role::find()->all(), 'RoleID', 'RoleName');

			if($MenuModel->load(Yii::$app->request->post())){

						if($MenuModel->Type == 0){
							//Menu y Subs Menus
							$PagesModel = Model::createMultiple(Page::classname());
		            		Model::loadMultiple($PagesModel, Yii::$app->request->post());
				            $valid = $MenuModel->validate();
				            $valid = Model::validateMultiple($PagesModel) && $valid;

					            if ($valid) {
					                $transaction = \Yii::$app->db->beginTransaction();

					                try {
					                    if ($flag = $MenuModel->save(false)){
					                        foreach ($PagesModel as $pageModel) {
					                            $pageModel->MenuID = $MenuModel->MenuID;
					                            if (! ($flag = $pageModel->save(false))){
					                            	Yii::$app->session->setFlash('error', "There was an error creating the menu.");
					                                $transaction->rollBack();
					                                break;
					                            }
					                        }
					                        foreach ($_POST['MenuByRole']['RoleID'] as $id => $_RolID){
					                        	$MenuByRole = new MenuByRole;
					                        	$MenuByRole->MenuID = $MenuModel->MenuID;
					                        	$MenuByRole->RoleID = $_RolID;
					                        	if (! ($flag = $MenuByRole->save(false))){
					                        		Yii::$app->session->setFlash('error', "There was an error creating the menu.");
					                                $transaction->rollBack();
					                                break;
					                            }
					                        }
					                    }

					                    if ($flag){
					                        $transaction->commit();
					                        Yii::$app->session->setFlash('success', "Menu created correctly");
					                         return $this->redirect(['/menu']);
					                    }
					                } catch (Exception $e) {
					                	Yii::$app->session->setFlash('error', "There was an error creating the menu.");
					                    $transaction->rollBack();
					                }
					            }else{
					            	Yii::$app->session->setFlash('error', "There is an incorrect data verification, please try again");
					            	$data['MenuModel'] = $MenuModel;
							    	$data['PagesModel'] = $PagesModel;
							    	$data['ModelsMenuByRole'] = $ModelsMenuByRole;
							    	$data['items'] = $items;

					            }

					    }else{

					    	///Menu Simple
					    	$valid = $MenuModel->validate();
					    	if ($valid){
					    		 $transaction = \Yii::$app->db->beginTransaction();
					    		 try {
					    		 	if ($flag = $MenuModel->save(false)) {
					    		 		foreach ($_POST['MenuByRole']['RoleID'] as $id => $_RolID) {
					                        	$MenuByRole = new MenuByRole;
					                        	$MenuByRole->MenuID = $MenuModel->MenuID;
					                        	$MenuByRole->RoleID = $_RolID;
					                        	if (! ($flag = $MenuByRole->save(false))) {
					                        		Yii::$app->session->setFlash('error', "There was an error creating the menu.");
					                                $transaction->rollBack();
					                                break;
					                            }
					                        }
					    		 	}

					    		 	if ($flag) {
					                        $transaction->commit();
					                        Yii::$app->session->setFlash('success', "Menu created correctly");
					                         return $this->redirect(['/menu']);
					                    }

					    		 } catch (Exception $e) {
					    		 		Yii::$app->session->setFlash('error', "There was an error creating the menu.");
					                    $transaction->rollBack();
					                }

					    	}else{
					            	Yii::$app->session->setFlash('error', "There is an incorrect data verification, please try again");
					            	$data['MenuModel'] = $MenuModel;
							    	$data['PagesModel'] = $PagesModel;
							    	$data['ModelsMenuByRole'] = $ModelsMenuByRole;
							    	$data['items'] = $items;

					            }

					    }
			
		   	}else{

			    $data['MenuModel'] = $MenuModel;
			    $data['PagesModel'] = $PagesModel;
			    $data['ModelsMenuByRole'] = $ModelsMenuByRole;
			    $data['items'] = $items;

			}
			// ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    Model::validateMultiple($PagesModel),
                    Model::validate($MenuModel)
                );
            }


			return $this->render('createmenu',$data);
		}




		public function actionUpdate($id){
			$this->_ValidUser = new ValidUsers;
			$this->_ValidUser->AccesControl([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = Yii::$app->session->get('UserData');
			$this->layout = $data['LayoutUser'];


			$MenuModel = Menu::findOne($id);
			$PagesModel = (!empty($MenuModel->page))? $MenuModel->page : [new Page] ;
			$roles = [];
			foreach ($MenuModel->menuByRole as $dat) {
				array_push($roles,$dat->RoleID);
			}
			$data['checkedList'] = $roles;
			$ModelsMenuByRole = new MenuByRole;
			$ModelsMenuByRole->isNewRecord = false;
			$items = ArrayHelper::map(Role::find()->all(), 'RoleID', 'RoleName');

			if($MenuModel->load(Yii::$app->request->post())){

						if($MenuModel->Type == 0){
							//Menu y Subs Menus
							$oldIDs = ArrayHelper::map($PagesModel, 'PageID', 'PageID');
							$PagesModel = Model::createMultiple(Page::classname());
		            		Model::loadMultiple($PagesModel, Yii::$app->request->post());
		            		$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($PagesModel, 'PageID', 'PageID')));
				            $valid = $MenuModel->validate();
				            $valid = Model::validateMultiple($PagesModel) && $valid;

					            if ($valid) {
					                $transaction = \Yii::$app->db->beginTransaction();

					                try {
					                	$MenuModel->Path = null;
					                    if ($flag = $MenuModel->save(false)){
					                    		if (! empty($deletedIDs)) {
							                            Page::deleteAll(['PageID' => $deletedIDs]);
							                        }
					                        foreach ($PagesModel as $pageModel) {
					                            $pageModel->MenuID = $MenuModel->MenuID;
					                            if (! ($flag = $pageModel->save(false))){
					                            	Yii::$app->session->setFlash('error', "There was an error updating the menu.");
					                                $transaction->rollBack();
					                                break;
					                            }
					                        }
					                        if(MenuByRole::deleteAll(['MenuID' => $MenuModel->MenuID])){
						                        foreach ($_POST['MenuByRole']['RoleID'] as $id => $_RolID){
						                        	$MenuByRole = new MenuByRole;
						                        	$MenuByRole->MenuID = $MenuModel->MenuID;
						                        	$MenuByRole->RoleID = $_RolID;
						                        	if (! ($flag = $MenuByRole->save(false))){
						                        		Yii::$app->session->setFlash('error', "There was an error updating the menu.");
						                                $transaction->rollBack();
						                                break;
						                            }
						                        }
					                  	  }
					                    }

					                    if ($flag){
					                        $transaction->commit();
					                        Yii::$app->session->setFlash('success', "Menu update correctly");
					                         return $this->redirect(['/menu']);
					                    }
					                } catch (Exception $e) {
					                	Yii::$app->session->setFlash('error', "There was an error updating the menu.");
					                    $transaction->rollBack();
					                }
					            }else{
					            	Yii::$app->session->setFlash('error', "There is an incorrect data verification, please try again");
					            	$data['MenuModel'] = $MenuModel;
							    	$data['PagesModel'] = $PagesModel;
							    	$data['ModelsMenuByRole'] = $ModelsMenuByRole;
							    	$data['items'] = $items;

					            }

					    }else{

					    	///Menu Simple
					    	$valid = $MenuModel->validate();
					    	// var_dump($MenuModel->ControllerUse);exit();
					    	if ($valid){
					    		 $transaction = \Yii::$app->db->beginTransaction();
					    		 try {
					    		 	Page::deleteAll(['MenuID' => $MenuModel->MenuID]);
					    		 	if ($flag = $MenuModel->save(false)) {
					    		 		if(MenuByRole::deleteAll(['MenuID' => $MenuModel->MenuID])){
						    		 		foreach ($_POST['MenuByRole']['RoleID'] as $id => $_RolID) {
						                        	$MenuByRole = new MenuByRole;
						                        	$MenuByRole->MenuID = $MenuModel->MenuID;
						                        	$MenuByRole->RoleID = $_RolID;
						                        	if (! ($flag = $MenuByRole->save(false))) {
						                        		Yii::$app->session->setFlash('error', "There was an error updating the menu.");
						                                $transaction->rollBack();
						                                break;
						                            }
						                        }
					                    }
					    		 	}

					    		 	if ($flag) {
					                        $transaction->commit();
					                        Yii::$app->session->setFlash('success', "Menu update correctly");
					                         return $this->redirect(['/menu']);
					                    }

					    		 } catch (Exception $e) {
					    		 		Yii::$app->session->setFlash('error', "There was an error updating the menu.");
					                    $transaction->rollBack();
					                }

					    	}else{
					            	Yii::$app->session->setFlash('error', "There is an incorrect data verification, please try again");
					            	$data['MenuModel'] = $MenuModel;
							    	$data['PagesModel'] = $PagesModel;
							    	$data['ModelsMenuByRole'] = $ModelsMenuByRole;
							    	$data['items'] = $items;

					            }

					    }
			
		   	}else{

			    $data['MenuModel'] = $MenuModel;
			    $data['PagesModel'] = $PagesModel;
			    $data['ModelsMenuByRole'] = $ModelsMenuByRole;
			    $data['items'] = $items;

			}
			// ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    Model::validateMultiple($PagesModel),
                    Model::validate($MenuModel)
                );
            }


			return $this->render('createmenu',$data);
		}



	}