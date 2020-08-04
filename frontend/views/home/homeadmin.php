<?php 
use frontend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
    $this->title = 'Bienvenido usuario administrador';
 ?>
<div class="container-fluid" style="color: var(--color-principal);text-align: center;">
	<div>
		<img src="<?= Yii::getAlias("@web"); ?>/images/logo.png" class="img-rounded" style=";width: auto; height: 200px;">
	</div>
	<h1>Bienvenido usuario administrador</h1>
</div>