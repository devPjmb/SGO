<?php 
    namespace common\models;

    use yii;
    use yii\base\Model;
    use yii\base\NotSupportedException;
    use yii\db\ActiveRecord;
    use yii\web\UploadedFile;

    class MBproducts extends ActiveRecord
    {
        public static function tableName()
        {
            return '{{%MBproducts}}';
        }

         public function rules()
        {
            return [
                [['MaquinasID', 'ProductsID'], 'required'],
                [['ProductsID','MaquinasID','MBproductsID'], 'integer', 'integerOnly'=>true],
            ];
        }

        public function getMaquinas()
        {
            return $this->hasOne(Maquinas::className(), ['MaquinasID' => 'MaquinasID']);
        }

        public function getProducts()
        {
            return $this->hasOne(Products::className(), ['ProductsID' => 'ProductsID']);
        }
    }

?>