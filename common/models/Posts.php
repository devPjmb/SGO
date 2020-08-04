<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

class Posts extends ActiveRecord 
{
    public $PhotoBlog;
    public static function tableName()
    {
        return '{{%Posts}}';
    }

    public function rules()
    {
        return [
            [['Tittle'], 'required'],
            [['ImageUrl','Content'], 'string'],
            [['PhotoBlog'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],

        ];
    }
     public function upload()
    {
        if ($this->validate()) {
            $this->ImageUrl = $this->PhotoBlog->baseName . "-". substr(md5(uniqid(rand())),0,6) . '.' . $this->PhotoBlog->extension;
            $this->PhotoBlog->saveAs(Yii::$app->basePath.'/../images/blog/' .$this->ImageUrl );
            $this->PhotoBlog = null;

            return true;
        } else {
            return false;
        }
    }
    
        /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

}
?>