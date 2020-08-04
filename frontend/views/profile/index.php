<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
    $this->title = 'Perfil de usuario';
?>
<div class="container-fluid">
	<h1 style="color:var(--color-principal);">Datos de perfil</h1>
	<div class="row-fluid">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
          <div class="alert alert-success alert-dismissable">
          		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
          		<h4><i class="icon fa fa-check"></i>¡Guardado!</h4>
          		<?= Yii::$app->session->getFlash('success') ?>
          	</div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('Error')): ?>
          <div class="alert alert-danger alert-dismissable">
          		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
          		<h4><i class="icon fa fa-check"></i>Error!</h4>
          		<?= Yii::$app->session->getFlash('error') ?>
          	</div>
        <?php endif; ?>
    </div>
	<hr> 
	<?php $form = ActiveForm::begin([
	'id' => 'form-Account',
	'action'=>['profile/update'],
	'options' => ['enctype' => 'multipart/form-data'],
	]); ?>

 	<div class="row-fluid" style="color: black;">
        <div class="col-sm-5">
        	<div class="row">
            	<div class="col-sm-7">
	                <a href="#">
				        <img src="<?= $ModelUserAccount->PhotoUrl? Yii::getAlias('@web').'/images/profile/'.$ModelUserAccount->PhotoUrl : Yii::getAlias('@proyect').'/images/profile/UserDefault.svg';?>" alt="Imagen de Perfil" class="img-responsive img-circle" id="ViewProfileIMG"	style="margin: 0 auto 10px;">
				    </a> 
				</div>
			</div>
			<div class="row-fluid">
              	<?= $form->field($ModelUserAccount, 'PhotoProfile')->fileInput(['id' => 'profileimg']); ?>
        	</div>
		</div>
		<div class="col-sm-7" style=" color: black;">
			<div class="row">
				<h3 style="color: var(--color-principal) !important;"><?php foreach ($ModelUserAccount->userByRole as $UserRole): echo $UserRole->role->RoleName.", "; endforeach; ?></h3>
			</div>
			<div class="row">
				<?= $form->field($ModelUserAccount, 'UserName')->textInput(['maxlength' => true]); ?>
            </div>
            <div class="row">
               <?= $form->field($ModelUserAccount, 'UserPassword')->textInput(['maxlength' => true]); ?>
            </div>
		</div>
    </div>
</div>

<div class="container-fluid">
	<?php if($ModelAgency): ?>
		<div class="panel panel-info" style="border-color:var(--color-principal);">
			<div class="panel-heading" style="color: #fff;background-color: var(--color-principal);border-color: var(--color-principal) !important;">
				<p>Información personal</p>
			</div>
			<div class="panel-body" style="color: black">
	 		<div class="row">
                <div class="col-sm-6">
                    <?= $form->field($ModelAgency, 'FirstName')->textInput(['maxlength' => true]); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($ModelAgency, 'LastName')->textInput(['maxlength' => true]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($ModelAgency, 'Address1')->textInput(['maxlength' => true]); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($ModelAgency, 'Address2')->textInput(['maxlength' => true]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($ModelAgency, 'BusinessPhone')->textInput(['maxlength' => true]); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($ModelAgency, 'Extension')->textInput(['maxlength' => true]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                   <?= $form->field($ModelAgency, 'CompanyName')->textInput(['maxlength' => true]); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($ModelAgency, 'Country')->dropDownList($items); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($ModelAgency, 'City')->textInput(['maxlength' => true]); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($ModelAgency, 'State')->textInput(['maxlength' => true]); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($ModelAgency, 'ZipCode')->textInput(['maxlength' => true]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($ModelAgency, 'CompanyWebSite')->textInput(['maxlength' => true]); ?>
                </div>
            </div>
       	</div>
    </div>
<?php endif; ?>
<div class="row">
	<div class="col-sm-12">
		<?= Html::submitButton('<i class="fa fa-floppy-o"></i> Guardar todos los cambios', ['class' => 'btn btn-color-especial']) ?>
	</div>
</div>
</div>



	 <?php ActiveForm::end(); ?>

<?php 
	$this->registerJs("
	$(function(){

		function readURL(input) {

		    if (input.files && input.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		            $('#ViewProfileIMG').attr('src', e.target.result);
		        }

		        reader.readAsDataURL(input.files[0]);
		    }
		}


		  $('#profileimg').change(function(){

		  	 readURL(this);

		  });
	  	});
	");
?>
