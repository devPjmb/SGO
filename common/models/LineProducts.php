<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	use yii\web\UploadedFile;
	/**
	 * This is the model class for table "Menu".
	 *
	 * @property integer $MenuID
	 * @property string $MenuName
	 * @property string $ClassIcon
	 * @property string $ControllerUse
	 * @property integer $Type
	 * @property string $Path
	 *
	 * @property Page[] $page
	 */
	
	class LineProducts extends ActiveRecord
	{
		use \common\components\RelationTrait;

		 /**
	     * @inheritdoc
	     */
	    public $PhotoLineProducts;
		public static function tableName()
		{
			return '{{%LineProducts}}';
		}
		/**
	     * @inheritdoc
	     */
	    public function rules()
	    {
	        return [
	            [['Name', 'Description','Color'], 'required'],
	            [['Name'], 'string', 'max' => 120],
	            [['PhotoLineProducts'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
	        ];
	    }

	    public function upload()
	    {
	        if ($this->validate()) {
	            $this->ImageUrl = $this->PhotoLineProducts->baseName . "-" . substr(md5(uniqid(rand())),0,6) . '.' . $this->PhotoLineProducts->extension;
	            $this->PhotoLineProducts->saveAs(Yii::$app->basePath . '/../images/Products/' . $this->ImageUrl );
	            $this->PhotoLineProducts = null;

	            return true;
	        } else {
	            return false;
	        }
	    }

		/**
	    * @return \yii\db\ActiveQuery
	     */
	    public function getProducts()
	    {
	        return $this->hasMany(Products::className(), ['LineProductsID' => 'LineProductsID']);
	    }
	}

?>