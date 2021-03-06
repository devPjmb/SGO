<?php 
	namespace frontend\controllers;
	use Yii;
	use yii\web\Controller;
	use yii\filters\VerbFilter;
	use yii\filters\AccessControl;

    use common\models\Country;
    use common\models\ValidarUser;
    use common\models\Social;

	use common\components\ValidUsers;
	use yii\helpers\ArrayHelper;

	use yii\data\ActiveDataProvider;
	use yii\db\Expression;
	

	class SocialController extends Controller
	{
		private $_valiUser;
        
        //funcion que llama la vista principal de usuarios
        public function actionIndex()
        {
        	$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();
			$data['model'] = new Social;
			$model = Social::find();

			$data['dataProvider']  = new ActiveDataProvider([
			    'query' => $model,
			    'pagination' => [
			        'pageSize' => 20,
			    ],
			]);

			return $this->render('index', $data);
        }

        public function actionCreatesocial() {
        	$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			
			$model = new Social;
			$model->SocialName = $_POST['Social']['SocialName'];
			$model->Icon = $_POST['Social']['Icon'];
			$model->Url = $_POST['Social']['Url'];
			//$model->save();
				
			$transaction = \Yii::$app->db->beginTransaction();
			$model->validate();
			if ($model->save()) {
				$transaction->commit();
				Yii::$app->session->setFlash('success', "Social Network create correctly.");
				return $this->redirect(['/social']);
			} else{
				Yii::$app->session->setFlash('error', "There was an error while saving the Social network.");
				$transaction->rollBack();
				$this->redirect(['/social']);
			} 	
    }
    	public function actionAjaxsocial(){
    		$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			$id = $_POST['id'];
			$dataRole = Social::findOne($id);
			$data['SocialID'] = $dataRole->SocialID;
			$data['SocialName'] = $dataRole->SocialName;
			$data['Icon'] = $dataRole->Icon;
			$data['Url'] = $dataRole->Url;
			echo json_encode($data);
		}

        public function actionUpdatesocial() {
        	$UserData =  Yii::$app->AccessControl->Verify([1,2]);
        	$model = Social::findOne($_POST['Social']['SocialID']);

			$transaction = \Yii::$app->db->beginTransaction();
			if($model->load(Yii::$app->request->post())) {
				$model->validate();
				if ($model->save()) {
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Social network update correctly.");
					return $this->redirect(['/social']);
				} else{
					Yii::$app->session->setFlash('error', "There was an error while saving the social network.");
					$transaction->rollBack();
					$this->redirect(['/social']);
				} 	
			}
        }

        public function actionDeletesocial($id) {
        	$UserData =  Yii::$app->AccessControl->Verify([1,2]);
			$id = Social::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($id->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Social network delete correctly.");
					$this->redirect(['/social']);
				}else{
					Yii::$app->session->setFlash('error', "There was an error.");
					$transaction->rollBack();
					$this->redirect(['/social']);
				}
			} catch (Exception $e) {
				Yii::$app->session->setFlash('error', "There was an error.");
				$transaction->rollBack();
				$this->redirect(['/social']);	
			}	
		}
       
    }
?>