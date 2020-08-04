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
    use common\models\Products;

    
	use yii\data\ActiveDataProvider;


	class ProductsController extends Controller
	{
		private $_ValidUser;

		public function actionIndex(){
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();
			$data['ModelLineProducts']  = $ModelLineProducts = Products::find();

			$data['dataProvider']  = new ActiveDataProvider([
				    'query' => $ModelLineProducts,
				    'pagination' => [
				        'pageSize' => 20,
				    ],
				]);

			return $this->render('index',$data);
		}

		public function actionDelete($id){
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			// $data = Yii::$app->session->get('UserData');

			$this->layout = false;
			$modelTarget = Products::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($modelTarget->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Producto eliminado correctamente.");
					$this->redirect(['/products']);
				}else{
					Yii::$app->session->setFlash('error', "Se ha producido un error al eliminar los productos.");
					$transaction->rollBack();
					$this->redirect(['/products']);

				}
			} catch (Exception $e) {

				Yii::$app->session->setFlash('error', "Se ha producido un error al eliminar los productos.");
				$transaction->rollBack();
				$this->redirect(['/products']);
			}
			
			
		}


		public function actionCreate(){
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();

			$data['LineProductsModel']  = new Products;

			if($data['LineProductsModel']->load(Yii::$app->request->post())){
				if($data['LineProductsModel']->validate()){
					$transaction = \Yii::$app->db->beginTransaction();
                        		try {

						$data['LineProductsModel']->PhotoProducts  = UploadedFile::getInstance($data['LineProductsModel'], 'PhotoProducts');
							if($data['LineProductsModel']->PhotoProducts != null)
								$upload = $data['LineProductsModel']->upload();
						if($data['LineProductsModel']->save()){
							$transaction->commit();
							Yii::$app->session->setFlash('success', "Producto creado correctamente.");
							$this->redirect(['/products']);

						}
					} catch (Exception $e) {

                               			Yii::$app->session->setFlash('error', "Se ha producido un error al crear los productos.");
                               			$transaction->rollBack();
                        		        $this->redirect(['/products']);
        		                }
	
				}else{
					Yii::$app->session->setFlash('success', "Los datos introducidos no son correctos. Inténtalo de nuevo.");
                                        $this->redirect(['/products/create']);

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

			$data['LineProductsModel']  =  Products::findOne($id);
			if($data['LineProductsModel']->load(Yii::$app->request->post())){
				if($data['LineProductsModel']->validate())
				{
					$transaction = \Yii::$app->db->beginTransaction();
	        		try 
	        		{
						$data['LineProductsModel']->PhotoProducts  = UploadedFile::getInstance($data['LineProductsModel'], 'PhotoProducts');
						if($data['LineProductsModel']->PhotoProducts != null)
							$upload = $data['LineProductsModel']->upload();
						if($data['LineProductsModel']->save()){
							$transaction->commit();
							Yii::$app->session->setFlash('success', "Producto actualizado correctamente.");
	                        $this->redirect(['/products']);
						}
					}catch (Exception $e) 
					{

	       			 	Yii::$app->session->setFlash('error', "Se ha producido un error al actualizar el producto.");
	           			$transaction->rollBack();
	    		        $this->redirect(['/products']);
	                }

				}else{
					Yii::$app->session->setFlash('success', "Los datos introducidos no son correctos. Inténtalo de nuevo.");
	                $this->redirect(['/products/create']);
				}
			}

			return $this->render('form',$data);
		}

	}
