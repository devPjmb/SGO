<?php 
    namespace common\models;

    use yii;
    use yii\base\Model;
    use yii\base\NotSupportedException;
    use yii\db\ActiveRecord;
    use yii\web\UploadedFile;

    class Products extends ActiveRecord
    {
        public $PhotoProducts;
        public static function tableName()
        {
            return '{{%Products}}';
        }
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['Description', 'Size', 'Name'], 'required'],
                [['ImageUrl','Description','Name','Size'], 'string'],
                [['PhotoProducts'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            ];
        }

        public function upload()
        {
            if ($this->validate()) {
                $this->ImageUrl = $this->PhotoProducts->baseName . "-" . substr(md5(uniqid(rand())),0,6) . '.' . $this->PhotoProducts->extension;
                $this->PhotoProducts->saveAs(Yii::$app->basePath . '/../images/Products/' . $this->ImageUrl );
                $this->PhotoProducts = null;

                return true;
            } else {
                return false;
            }
        }

        public function attributeLabels()
        {
            return [
                'Description' => 'Descripción',
                'Name' => 'Nombre',
                'Size' => 'Tamaño',
                'Preview target' => 'Vista previa',
                'PhotoProducts' => 'Foto de producto',
                'Tamaño de producto' => 'Tamaño',
            ];
        }

       public function getMBproducts()
        {
            return $this->hasMany(MBproducts::className(), ['ProductsID' => 'ProductsID']);
        }
        /**
        * @return \yii\db\ActiveQuery
        
        public function getLineProducts()
        {
            return $this->hasOne(LineProducts::className(), ['LineProductsID' => 'LineProductsID']);
        }


 */
    }

?>