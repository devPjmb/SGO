<?php
namespace componets;

use Yii;
use yii\componets;

class UserIdentity extends Componets
{
    public function authenticate(){
        $registro = UserAccount::model()->findByAttributes(array('UserName' => $this->username));
	 
	if ($registro === null) {
	$this->errorCode = self::ERROR_USERNAME_INVALID;
	} elseif ($registro->UserPassword === md5($this->password)) {//
	$this->setState('id_usuario', $registro->AccountID);
	$this->setState('Imagen_usuario', $registro->PhotoUrl);
	if ($registro->UserByRole->Role->Service->ServiceName == 'Staff') {
			$this->setState('Nombre_usuario', 'Logged in as staff');
			$staff = '//layouts/staff';
			$staff_home = 'staff';
			$this->setState('id_layout', $staff);
			$this->setState('id_home', $staff_home);
			$this->setState('role_user', $registro->UserByRole->Role->RoleName);
		}
	if ($registro->UserByRole->Role->Service->ServiceName == 'Agency') {
			$this->setState('Nombre_usuario', 'Logged in as Agency');
			$staff = '//layouts/staff';
			$staff_home = 'products/productslist';
			$this->setState('id_layout', $staff);
			$this->setState('id_home', $staff_home);
			$this->setState('role_user', $registro->UserByRole->Role->RoleName);
		}
	if (($registro->UserByRole->Role->Service->ServiceName == 'Agency')&&($registro->UserByRole->Role->RoleName == 'Executive')) {
			$this->setState('Nombre_usuario', 'Logged in as Executive');
			$staff = '//layouts/staff';
			$staff_home = 'products/listsell';
			$this->setState('id_layout', $staff);
			$this->setState('id_home', $staff_home);
			$this->setState('role_user', $registro->UserByRole->Role->RoleName);
		}
	if ($registro->UserByRole->Role->Service->ServiceName == 'Buyer') {
			$Name = Buyer::model()->findByAttributes(array('AccountID' => $registro->AccountID));
			$this->setState('Nombre_usuario', $Name->FirstName);
			$buyer = '//layouts/public';
			$buyer_home = 'buyer/profile';
			$this->setState('id_layout', $buyer);
			$this->setState('id_home', $buyer_home);
			$this->setState('role_user', $registro->UserByRole->Role->RoleName);
			$this->setState('id_buyer', $Name->BuyerID);
		}
	if($registro->IsActive == 0){
		$this->errorCode =	'USER_DISABLED';
	}else{
	$this->errorCode = self::ERROR_NONE;
	}
	} else {
	$this->errorCode = self::ERROR_PASSWORD_INVALID;
	}
	return !$this->errorCode;
    }
}

?>