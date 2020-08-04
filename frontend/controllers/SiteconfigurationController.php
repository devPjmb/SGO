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

    // use common\models\Menu;
    use common\models\Model;
    use common\models\WebPageContent;

    
	use yii\data\ActiveDataProvider;


	class SiteconfigurationController extends Controller
	{
		private $_ValidUser;

		public function actionIndex(){
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();
			$data['ModelWebPageContent']  = $ModelWebPageContent = WebPageContent::find();

			$data['dataProvider']  = new ActiveDataProvider([
				    'query' => $ModelWebPageContent,
				    'pagination' => [
				        'pageSize' => 20,
				    ],
				]);
			

			// $data['searchModel'] = $searchModel = new Menu();
			// $data['dataProvider'] = $dataProvider = Menu::find()->all();

			return $this->render('index',$data);
		}

		public function actionDelete($id){
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			// $data = Yii::$app->session->get('UserData');

			$this->layout = false;
			$modelWebPageContent = WebPageContent::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($modelWebPageContent->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Content delete correctly.");
					$this->redirect(['/siteconfiguration']);
				}else{
					Yii::$app->session->setFlash('error', "There was an error Deleting content.");
					$transaction->rollBack();
					$this->redirect(['/siteconfiguration']);

				}
			} catch (Exception $e) {

				Yii::$app->session->setFlash('error', "There was an error deleting the content.");
				$transaction->rollBack();
				$this->redirect(['/siteconfiguration']);
			}
			
			
		}


		public function actionCreate(){
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();


			$ModelWebPageContent = new WebPageContent;

			if($ModelWebPageContent->load(Yii::$app->request->post())){

				if($ModelWebPageContent->validate()){
					$upload = true;
					$ModelWebPageContent->UploadImage = UploadedFile::getInstance($ModelWebPageContent, 'UploadImage');
					if($ModelWebPageContent->UploadImage != null)
							$upload = $ModelWebPageContent->upload();

						if($upload){
							if($ModelWebPageContent->save()){
								Yii::$app->session->setFlash('success', "Insert correctly");
								return $this->redirect(['/siteconfiguration']);
							}else{
								$data['ModelWebPageContent'] = $ModelWebPageContent;
							 	Yii::$app->session->setFlash('error', "There was an error creating content.");

							}
						}else{
							$data['ModelWebPageContent'] = $ModelWebPageContent;
							Yii::$app->session->setFlash('error', "Fail to upload Image.");
						}
				}else{

					Yii::$app->session->setFlash('error', "There was an error creating content check the data.");
				}
			
		   	}
			    $data['ModelWebPageContent'] = $ModelWebPageContent;

			// ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    WebPageContent::validate($ModelWebPageContent)
                );
            }


			return $this->render('form',$data);
		}




		public function actionUpdate($id){
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();


			$WebPageContent = WebPageContent::findOne($id);
			if($WebPageContent->load(Yii::$app->request->post())){

				if($WebPageContent->validate()){
					$upload = true;
					$WebPageContent->UploadImage = UploadedFile::getInstance($WebPageContent, 'UploadImage');
					if($WebPageContent->UploadImage != null)
							$upload = $WebPageContent->upload();

						if($upload){
							if($WebPageContent->save()){
								Yii::$app->session->setFlash('success', "Insert correctly");
								return $this->redirect(['/siteconfiguration']);
							}else{
								$data['ModelWebPageContent'] = $WebPageContent;
							 	Yii::$app->session->setFlash('error', "There was an error creating insert.");

							}
						}else{
							$data['ModelWebPageContent'] = $WebPageContent;
							Yii::$app->session->setFlash('error', "Fail to upload Image.");
						}

				}else{
					Yii::$app->session->setFlash('error', "There was an error creating content check the data.");
				}
			
		   	}

			    $data['ModelWebPageContent'] = $WebPageContent;
			// ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    WebPageContent::validate($WebPageContent)
                );
            }


			return $this->render('form',$data);
		}



	}