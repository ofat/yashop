<?php
use admin\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);

            /*
             * Main menu
             */
            $menuItems = [
                ['label' => Yii::t('base','Home'), 'url' => ['/dashboard']],
                ['label' => Yii::t('user','Users'), 'url' => ['/user/list']],
                ['label' => Yii::t('base','Settings'), 'url' => '', 'items'=> [
                    ['label' => Yii::t('admin.country', 'Countries'), 'url' => ['/settings/country']],
                    ['label' => Yii::t('admin.currency', 'Currencies'), 'url' => ['/settings/currency']],
                    ['label' => Yii::t('admin.language', 'Languages'), 'url' => ['/settings/language']]
                ]],
                ['label' => Yii::t('base', 'Widgets'), 'url' => ['/widgets'], 'items' => [
                    ['label' => Yii::t('admin.menu', 'Menu'), 'url' => ['/widgets/menu']],
                    ['label' => Yii::t('admin.promo', 'Promo items'), 'url' => ['/widgets/promo']]
                ]]
            ];

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => $menuItems,
            ]);

            /*
             * Right menu nav
             */
            $rightMenu = [];
            if (Yii::$app->user->isGuest) {
                $rightMenu[] = ['label' => 'Login', 'url' => ['/login']];
            } else {
                $rightMenu[] = [
                    'label' => Yii::t('user','Logout').' (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $rightMenu,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; <?=Yii::$app->name?> <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
