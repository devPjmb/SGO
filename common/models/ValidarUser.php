<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Agency;
use common\models\UserAccount;


class ValidarUser extends Model
{
    public $Correo;
    public $Password;
    public $Password2;
    public $Nombre;
		public $Apellido;
		public $Direccion;
    public $Direccion2;
		public $Telefono;
    public $Telefono2;
		public $Estado;
    public $ciudad;
    public $Url;
    public $Code;
    public $NCM;
    public $Rol;
     public function rules()
    {
			return
			[
              [['Nombre','lastname', 'Direccion', 'Correo', 'Password', 'Password2', 'Telefono', 'Apellido', 'Rol'], 'required'],
              'ciudad'=> [['ciudad'], 'string', 'max'=> 25],
              'Estado'=> [['Estado'], 'string', 'max'=>2],
              'NCM' => [['NCM'], 'string', 'max'=>25],
              'Direccion2' => [['Direccion2'], 'string', 'max'=>25],
              ['Nombre', 'unique'],
              ['Nombre', 'exist'],
              [['Telefono','Code', 'Telefono2'], 'integer', 'integerOnly' => true, 'min' => 0],
              ['Url', 'url', 'defaultScheme' => 'http'],
              ['Password2', 'compare', 'compareAttribute' => 'Password'],  
              ['correo','email'],         
			];
    }
}


?>