<?php 
	namespace frontend\controllers;
	use Yii;
	use yii\web\Controller;
	use yii\filters\VerbFilter;
	use yii\filters\AccessControl;
    use common\models\UserAccount;
    use DateTime;

	use yii\helpers\ArrayHelper;

	use yii\data\ActiveDataProvider;
	use yii\data\BaseDataProvider;
	use yii\db\Expression;

	class ReportController extends Controller
	{
		private $_valiUser;

		public function actionIndex()
		{
			$UserData =  Yii::$app->AccessControl->Verify([1,2,4]);
			$this->layout = $UserData->getLayout();
			
			$data = [];
			$data['modelUser'] = new UserAccount;

			$data['listUser']  =  ArrayHelper::map(UserAccount::find()->all(), 'AccountID', function ($data) {
				return $data->UserName;
			});
			return $this->render('index', $data);
		}

		public function actionGenerate()
		{
			var_dump($_POST);exit();
		}
	}