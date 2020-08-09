<?php 
    use frontend\assets\AppAssetLayoutAll;
    AppAssetLayoutAll::register($this);
    
    use frontend\assets\AppAsset;
    use yii\helpers\Html;
    use yii\bootstrap\Button;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\ArrayHelper;

    use common\components\chosen\Chosen;
    use common\components\datepicker\DatePicker;

    date_default_timezone_set('America/Caracas');

    $this->title = 'Generacion de Reportes';
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">

    <h1><?= $this->title; ?></h1>
    <hr>
    <div class="row-fluid">
    <?php $form = ActiveForm::begin(['action' =>['generate'], 'id' => 'generate', 'method' => 'post','enableClientValidation' => true,
     ]); ?> 
        <div class="form-group col-lg-6">
            <?= $form->field($modelUser, 'AccountID')->widget(
                Chosen::className(), [
                'items' => $listUser,
                'id' => 'OrderIDP',
                'placeholder'=>'Buscar Usuario',
                'allowDeselect' => true,
                'disableSearch' => false,
                'clientOptions' => [
                  'search_contains' => true,
                  'max_selected_options' => 1,
                ],
                ])->label('Usuario'); 
            ?>
        </div>
        <div class="form-group col-lg-6">
            <?= $form->field($modelUser, 'AuditDate')->widget(
                DatePicker::className(),[
                    'options' => [
                        'class' => 'form-control'
                    ],
                    'clientOptions' => [
                        'format' => 'YYYY-MM-DD', 'stepping' => 30
                    ]
                ])->label('Desde');
            ?>
        </div>
        <div class="col-lg-12" style="display: flex;justify-content: center;align-items: center;">
            <?= Html::submitButton('Generar', ['class' => 'btn btn-color-especial click-confirm', "style"=>'width:25%']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    </div>

</div>