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
    use common\models\Posts;

    
	use yii\data\ActiveDataProvider;

	// $_SESSION['KCFINDER']['disabled'] = false;
	// $_SESSION['KCFINDER']['uploadURL'] = $url."/images/blog/";
	// $_SESSION['KCFINDER']['uploadDir'] = Yii::getAlias('@proyect')."/images/blog/";
	class BlogController extends Controller
	{
		private $_ValidUser;

		public function actionIndex(){
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();

			$data['ModelPosts']  = $modelPosts = Posts::find();

			$data['dataProvider']  = new ActiveDataProvider([
				    'query' => $modelPosts,
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
			$modelPosts = Posts::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($modelPosts->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Post delete correctly.");
					$this->redirect(['/blog']);
				}else{
					Yii::$app->session->setFlash('error', "There was an error Deleting Post.");
					$transaction->rollBack();
					$this->redirect(['/blog']);

				}
			} catch (Exception $e) {

				Yii::$app->session->setFlash('error', "There was an error deleting the post.");
				$transaction->rollBack();
				$this->redirect(['/blog']);
			}
			
			
		}


		public function actionCreatepost(){
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();
			
			/////////////////Importante para el funcionamiento de///////////////////////
			/////////////////kcfinder y CKeditor carga de archivos//////////////////////
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			$url=$protocol.$_SERVER['HTTP_HOST'].Yii::getAlias('@proyect');
				 $configkcfinder = fopen(Yii::getAlias('@webroot').'/settingkcfinder.txt', 'w');
				 $uploadURL = $url."/images/blog/";
				 $uploadDir = Yii::getAlias('@webroot')."/../images/blog/";
				 $datafile = json_encode(array('uploadURL' =>  $uploadURL,'uploadDir' => $uploadDir));
				 fwrite($configkcfinder,$datafile);
				 fclose($configkcfinder);
			 ///////////////////////////////////////////////////////////////////////////////


			$ModelPost = new Posts;

			if($ModelPost->load(Yii::$app->request->post())){
				if($ModelPost->validate()){
					$upload = true;
					$ModelPost->PhotoBlog = UploadedFile::getInstance($ModelPost, 'PhotoBlog');
					if($ModelPost->PhotoBlog != null)
							$upload = $ModelPost->upload();

						if($upload){
							if($ModelPost->save()){
								Yii::$app->session->setFlash('success', "Blog Post Insert correctly");
								return $this->redirect(['/blog']);
							}else{
								$data['ModelPost'] = $ModelPost;
							 	Yii::$app->session->setFlash('error', "There was an error creating blog post.");

							}
						}else{
							$data['ModelPost'] = $ModelPost;
							Yii::$app->session->setFlash('error', "Fail to upload Image.");
						}
				}else{

					Yii::$app->session->setFlash('error', "There was an error creating blog post check the data.");
				}
			
		   	}
			    $data['ModelPost'] = $ModelPost;

			// ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    Posts::validate($ModelPost)
                );
            }


			return $this->render('posts',$data);
		}




		public function actionUpdate($id){
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();

			/////////////////Importante para el funcionamiento de///////////////////////
			/////////////////kcfinder y CKeditor carga de archivos//////////////////////
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			$url=$protocol.$_SERVER['HTTP_HOST'].Yii::getAlias('@proyect');
				 $configkcfinder = fopen(Yii::getAlias('@webroot').'/settingkcfinder.txt', 'w');
				 $uploadURL = $url."/images/blog/";
				 $uploadDir = Yii::getAlias('@webroot')."/../images/blog/";
				 $datafile = json_encode(array('uploadURL' =>  $uploadURL,'uploadDir' => $uploadDir));
				 fwrite($configkcfinder,$datafile);
				 fclose($configkcfinder);
			 ///////////////////////////////////////////////////////////////////////////////


			$ModelPost = Posts::findOne($id);
			if($ModelPost->load(Yii::$app->request->post())){
				//$ModelPost->Content = Yii::$app->request->post()['Posts']['Content'];
				if($ModelPost->validate()){
					$upload = true;
					$ModelPost->PhotoBlog = UploadedFile::getInstance($ModelPost, 'PhotoBlog');
					if($ModelPost->PhotoBlog != null)
							$upload = $ModelPost->upload();

						if($upload){
							if($ModelPost->save()){
								Yii::$app->session->setFlash('success', "Blog Post Insert correctly");
								return $this->redirect(['/blog']);
							}else{
								$data['ModelPost'] = $ModelPost;
							 	Yii::$app->session->setFlash('error', "There was an error creating blog post.");

							}
						}else{
							$data['ModelPost'] = $ModelPost;
							Yii::$app->session->setFlash('error', "Fail to upload Image.");
						}

				}else{
					Yii::$app->session->setFlash('error', "There was an error creating blog post check the data.");
				}
			
		   	}

			    $data['ModelPost'] = $ModelPost;
			// ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    Posts::validate($ModelPost)
                );
            }


			return $this->render('posts',$data);
		}



	}