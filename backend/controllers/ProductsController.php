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
    use common\models\LineProducts;
    use common\models\Products;

    
	use yii\data\ActiveDataProvider;


	class ProductsController extends Controller
	{
		private $_ValidUser;

		public function actionIndex(){
			$this->_ValidUser = new ValidUsers;
			$this->_ValidUser->AccesControl([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = Yii::$app->session->get('UserData');
			$this->layout = $data['LayoutUser'];
			$data['ModelLineProducts']  = $ModelLineProducts = LineProducts::find();

			$data['dataProvider']  = new ActiveDataProvider([
				    'query' => $ModelLineProducts,
				    'pagination' => [
				        'pageSize' => 20,
				    ],
				]);

			return $this->render('index',$data);
		}

		public function actionDelete($id){
			$this->_ValidUser = new ValidUsers;
			$this->_ValidUser->AccesControl([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			// $data = Yii::$app->session->get('UserData');

			$this->layout = false;
			$modelTarget = LineProducts::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($modelTarget->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Line Products delete correctly.");
					$this->redirect(['/products']);
				}else{
					Yii::$app->session->setFlash('error', "There was an error creating the line products.");
					$transaction->rollBack();
					$this->redirect(['/products']);

				}
			} catch (Exception $e) {

				Yii::$app->session->setFlash('error', "There was an error creating the line products.");
				$transaction->rollBack();
				$this->redirect(['/products']);
			}
			
			
		}


		public function actionCreate(){
			$this->_ValidUser = new ValidUsers;
			$this->_ValidUser->AccesControl([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = Yii::$app->session->get('UserData');
			$this->layout = $data['LayoutUser'];


			$LineProductsModel = new LineProducts;
			$ProductsModel = [new Products];
			//$items = ArrayHelper::map(Role::find()->all(), 'RoleID', 'RoleName');

			if($LineProductsModel->load(Yii::$app->request->post())){
				//Targets y Tips

				$upload = true;
				$LineProductsModel->PhotoLineProducts = UploadedFile::getInstance($LineProductsModel, 'PhotoLineProducts');
				if($LineProductsModel->PhotoLineProducts != null)
						$upload = $LineProductsModel->upload();


				$ProductsModel = Model::createMultiple(Products::classname());
        		Model::loadMultiple($ProductsModel, Yii::$app->request->post());
	            $valid = $LineProductsModel->validate();
	            $valid = Model::validateMultiple($ProductsModel) && $valid;

		            if ($valid) {
		                $transaction = \Yii::$app->db->beginTransaction();

		                try {
		                	if(!$upload){
								Yii::$app->session->setFlash('error', "Fail to upload Image.");
		                        $transaction->rollBack();
		                        $data['LineProductsModel'] = $LineProductsModel;
			    				$data['ProductsModel'] = $ProductsModel;
			    				return $this->render('form',$data);
							}
		                    if ($flag = $LineProductsModel->save(false)){
		                        foreach ($ProductsModel as $indexModel => $modelProducts) {
		                            $modelProducts->LineProductsID = $LineProductsModel->LineProductsID;

									$modelProducts->PhotoProducts = UploadedFile::getInstance($modelProducts, "[{$indexModel}]PhotoProducts");
									if($modelProducts->PhotoProducts != null)
										$upload = $modelProducts->upload();
									if(!$upload){
										Yii::$app->session->setFlash('error', "There was an error Upload img the Product.");
		                                $transaction->rollBack();
		                                break;
									}

		                            if (! ($flag = $modelProducts->save(false))){
		                            	Yii::$app->session->setFlash('error', "There was an error creating the menu.");
		                                $transaction->rollBack();
		                                break;
		                            }
		                        }
		                    }

		                    if ($flag){
		                        $transaction->commit();
		                        Yii::$app->session->setFlash('success', "Target and tips created correctly");
		                         return $this->redirect(['/products']);
		                    }
		                } catch (Exception $e) {
		                	Yii::$app->session->setFlash('error', "There was an error creating the Product Line.");
		                    $transaction->rollBack();
		                }
		            }else{
		            	Yii::$app->session->setFlash('error', "There is an incorrect data verification, please try again");
		            	$data['LineProductsModel'] = $LineProductsModel;
				    	$data['ProductsModel'] = $ProductsModel;

		            }
		   	}else{

			    $data['LineProductsModel'] = $LineProductsModel;
			    $data['ProductsModel'] = $ProductsModel;

			}
			// ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    Model::validateMultiple($ProductsModel),
                    Model::validate($LineProductsModel)
                );
            }


			return $this->render('form',$data);
		}




		public function actionUpdate($id){
			$this->_ValidUser = new ValidUsers;
			$this->_ValidUser->AccesControl([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = Yii::$app->session->get('UserData');
			$this->layout = $data['LayoutUser'];


			$LineProductsModel = LineProducts::findOne($id);
			$ProductsModel = (!empty($LineProductsModel->products))? $LineProductsModel->products : [new Products] ;

			if($LineProductsModel->load(Yii::$app->request->post())){

				$upload = true;
				$LineProductsModel->PhotoLineProducts = UploadedFile::getInstance($LineProductsModel, 'PhotoLineProducts');
				if($LineProductsModel->PhotoLineProducts != null)
						$upload = $LineProductsModel->upload();

				//Menu y Subs Menus
				$oldIDs = ArrayHelper::map($ProductsModel, 'ProductsID', 'ProductsID');
				$ProductsModel = Model::createMultiple(Products::classname());
        		Model::loadMultiple($ProductsModel, Yii::$app->request->post());
        		$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($ProductsModel, 'ProductsID', 'ProductsID')));
	            $valid = $LineProductsModel->validate();
	            $valid = Model::validateMultiple($ProductsModel) && $valid;

		            if ($valid) {
		                $transaction = \Yii::$app->db->beginTransaction();

		                try {
		                	if(!$upload){
								Yii::$app->session->setFlash('error', "Fail to upload Image.");
		                        $transaction->rollBack();
		                        $data['LineProductsModel'] = $LineProductsModel;
			    				$data['ProductsModel'] = $ProductsModel;
			    				return $this->render('form',$data);
							}
		                    if ($flag = $LineProductsModel->save(false)){
		                    		if (! empty($deletedIDs)) {
				                            Products::deleteAll(['ProductsID' => $deletedIDs]);
				                        }
		                        foreach ($ProductsModel as $indexModel => $modelProducts) {
		                            $modelProducts->LineProductsID = $LineProductsModel->LineProductsID;

		                            $modelProducts->PhotoProducts = UploadedFile::getInstance($modelProducts, "[{$indexModel}]PhotoProducts");
									if($modelProducts->PhotoProducts != null)
										$upload = $modelProducts->upload();

									if(!$upload){
										Yii::$app->session->setFlash('error', "There was an error Upload img the Product.");
		                                $transaction->rollBack();
		                                break;
									}

		                            if (! ($flag = $modelProducts->save(false))){
		                            	Yii::$app->session->setFlash('error', "There was an error updating the Product Line.");
		                                $transaction->rollBack();
		                                break;
		                            }
		                        }
		                    }

		                    if ($flag){
		                        $transaction->commit();
		                        Yii::$app->session->setFlash('success', "Product Line update correctly");
		                         return $this->redirect(['/products']);
		                    }
		                } catch (Exception $e) {
		                	Yii::$app->session->setFlash('error', "There was an error updating Product Line.");
		                    $transaction->rollBack();
		                }
		            }else{
		            	Yii::$app->session->setFlash('error', "There is an incorrect data verification, please try again");
		            	$data['LineProductsModel'] = $LineProductsModel;
				    	$data['ProductsModel'] = $ProductsModel;

		            }
			
		   	}else{

			    $data['LineProductsModel'] = $LineProductsModel;
			    $data['ProductsModel'] = $ProductsModel;

			}
			// ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    Model::validateMultiple($ProductsModel),
                    Model::validate($LineProductsModel)
                );
            }


			return $this->render('form',$data);
		}



	}