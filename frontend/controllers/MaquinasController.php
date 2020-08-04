<?php 
	namespace frontend\controllers;

	use Yii;
	use yii\web\Controller;
	use yii\web\UploadedFile;
    use common\components\ValidUsers;

	use yii\filters\VerbFilter;
    use yii\helpers\ArrayHelper;
	use yii\web\NotFoundHttpException;
	use yii\web\Response;

    use common\models\Model;
    use common\models\Maquinas;
    use common\models\Products;
    use common\models\MBproducts;

    
	use yii\data\ActiveDataProvider;


	class MaquinasController extends Controller
	{
		private $_ValidUser;

		public function actionIndex(){
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();
			$data['ModelLineMaquinas']  = $ModelLineMaquinas = Maquinas::find();

			$data['dataProvider']  = new ActiveDataProvider([
				    'query' => $ModelLineMaquinas,
				    'pagination' => [
				        'pageSize' => 20,
				    ],
				]);

			$modelMaquina = new Maquinas;
			$data['modelMaquina'] = $modelMaquina;

			$Products = new Products;
			$data['Products'] = $Products;

			$data['MbPModel'] = new MBproducts;

			$data['modelProducts'] = ArrayHelper::map(Products::find()->all(), 'ProductsID', 'Name');

			return $this->render('index',$data);
		}

		public function actionDelete($id){
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			// $data = Yii::$app->session->get('UserData');

			$this->layout = false;
			$modelTarget = Maquinas::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($modelTarget->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Maquina eliminada correctamente.");
					$this->redirect(['/maquinas']);
				}else{
					Yii::$app->session->setFlash('error', "Hubo un error eliminando las maquinas.");
					$transaction->rollBack();
					$this->redirect(['/maquinas']);

				}
			} catch (Exception $e) {

				Yii::$app->session->setFlash('error', "Hubo un error eliminando las maquinas.");
				$transaction->rollBack();
				$this->redirect(['/maquinas']);
			}
			
			
		}


		public function actionCreate(){
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();

			$data['LineMaquinasModel']  = new Maquinas;

			if($data['LineMaquinasModel']->load(Yii::$app->request->post())){
				if($data['LineMaquinasModel']->validate()){
					$transaction = \Yii::$app->db->beginTransaction();
                        		try {

						$data['LineMaquinasModel']->PhotoMaquinas  = UploadedFile::getInstance($data['LineMaquinasModel'], 'PhotoMaquinas');
							if($data['LineMaquinasModel']->PhotoMaquinas != null)
								$upload = $data['LineMaquinasModel']->upload();
						if($data['LineMaquinasModel']->save()){
							Yii::$app->session->setFlash('success', "Máquina creada correctamente");
							$transaction->commit();
		                                        $this->redirect(['/maquinas']);

						}
					} catch (Exception $e) {

                               			 Yii::$app->session->setFlash('error', "Hubo un error al crear la máquina.");
                               			$transaction->rollBack();
                        		        $this->redirect(['/maquinas']);
        		                }
	
				}else{
					Yii::$app->session->setFlash('success', "Los datos introducidos no son correctos. Inténtalo de nuevo.");
                                        $this->redirect(['/maquinas/create']);

				}

			}

			return $this->render('form',$data);
		}




		public function actionUpdate($id)
		{
			
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();

			$data['LineMaquinasModel']  =  Maquinas::findOne($id);
			if($data['LineMaquinasModel']->load(Yii::$app->request->post())){
				if($data['LineMaquinasModel']->validate())
				{
					$transaction = \Yii::$app->db->beginTransaction();
	        		try 
	        		{
						$data['LineMaquinasModel']->PhotoMaquinas  = UploadedFile::getInstance($data['LineMaquinasModel'], 'PhotoMaquinas');
						if($data['LineMaquinasModel']->PhotoMaquinas != null)
							$upload = $data['LineMaquinasModel']->upload();
						if($data['LineMaquinasModel']->save()){
							$transaction->commit();
							Yii::$app->session->setFlash('success', "Maquina actualizada correctamente.");
	                        $this->redirect(['/maquinas']);
						}
					}catch (Exception $e) 
					{

	       			 	Yii::$app->session->setFlash('error', "Hubo un error al actualizar la máquina..");
	           			$transaction->rollBack();
	    		        $this->redirect(['/maquinas']);
	                }

				}else{
					Yii::$app->session->setFlash('success', "Los datos introducidos no son correctos. Inténtalo de nuevo.");
	                $this->redirect(['/maquinas/create']);
				}
			}

			return $this->render('form',$data);
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////
		public function actionAssign() {
        	$UserData =  Yii::$app->AccessControl->Verify([1]);
        	$model = new MBproducts;

			$transaction = \Yii::$app->db->beginTransaction();
			try 
	    		{
					if($model->load(Yii::$app->request->post())) {
						$NewProducts = $model->ProductsID;
						if($model->MBproductsID){
								$model = MBproducts::findOne($model->MBproductsID);
								$model->ProductsID = $NewProducts;
							}

						$model->validate();
						if ($model->save()) {
							$transaction->commit();
							Yii::$app->session->setFlash('success', "Asignación realizada correctamente.");
							return $this->redirect(['maquinas/']);
						} else{
							Yii::$app->session->setFlash('error', "Se produjo un error en la asignación.");
							$transaction->rollBack();
							$this->redirect(['maquinas/']);
						} 	
					}
				}catch (Exception $e) 
				{

	   			 	Yii::$app->session->setFlash('error', "Hubo un error al asignar.");
	       			$transaction->rollBack();
			        $this->redirect(['maquinas/']);
	            }
        }

        public function actionAjaxassign(){
    		$UserData =  Yii::$app->AccessControl->Verify([1]);
			$id = $_POST['id'];
			$dataMaquinas = Maquinas::findOne($id);
			$data['MaquinasID'] = $dataMaquinas->MaquinasID;
			$data['Name'] = $dataMaquinas->Name;
			$data['Description'] = $dataMaquinas->Description;

			if (!empty($dataMaquinas->mBproducts->ProductsID)) {
				$data['ProductsID'] = $dataMaquinas->mBproducts->ProductsID;
				$data['MbPID'] = $dataMaquinas->mBproducts->MBproductsID;
			}
			
			echo json_encode($data);
		}

	}
