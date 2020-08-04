<?php 

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
$this->beginPage()
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'AgroExport',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Blog', 
          'items' => [
            ['label' => 'Control de Post', 'url' => '../blog/post'],
            ['label' => 'Control de Tags', 'url' => '../blog/tag'],
          ],
        ],
    ];
    $menuItems1 = [
        ['label' => 'Site', 
          'items' => [
            ['label' => '****', 'url' => '#'],
            ['label' => '****', 'url' => '#'],
          ],
        ],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems2[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems2[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (Admin)',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
     echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-inverse'],
        'items' => $menuItems,
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-inverse'],
        'items' => $menuItems1,
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems2,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div id="alert" class="alert alert-success alert-dismissible hidden" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <p id="msj"></p>
        </div>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
    <!-- CDN de Font-awesome  -->
    <script src="https://use.fontawesome.com/eb6f212b29.js"></script>
</html>
<?php $this->endPage() ?>
