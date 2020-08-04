<?php 
	namespace frontend\controllers;
	use Yii;
	use yii\web\Controller;
	use yii\filters\VerbFilter;
	use yii\filters\AccessControl;
    use common\models\Phases;
    use common\models\Clients;
    use common\models\Orders;
    use common\models\OrderByPhase;
    use DateTime;


	use yii\helpers\ArrayHelper;

	use yii\data\ActiveDataProvider;
	use yii\data\BaseDataProvider;
	use yii\db\Expression;

	class PendingpaymentsController extends Controller
	{
		private $_valiUser;

		public function actionIndex()
		{
			$UserData =  Yii::$app->AccessControl->Verify([1,2,4]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();
			$modelOrder = Orders::find()->where('(Status = 2 OR Status = 3)')->andWhere('RemainingAmount > "0.00"');
			//$this->pVarDump($modelOrder);
			$data['dataProvider']  = new ActiveDataProvider([
				'query' => $modelOrder,
				'pagination' => [
					'pageSize' => 20,
				],
			]);

			return $this->render('index', $data);
		}

		public function pVarDump($var)
		{
			echo "<pre>";var_dump($var);echo "</pre>";exit;
		}
	}
