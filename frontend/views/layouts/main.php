<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\MaterialAsset;
use kartik\icons\Icon;

//AppAsset::register($this);
MaterialAsset::register($this);


?>
<?php $this->beginPage() ?>
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
        'brandLabel' => '<span class="fa fa-database"></span> LHDC',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-fixed-top navbar-custom',
        ],
    ]);
            
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        //['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    
    //Start Menu group 1
    $rpt_menu_g1[] = ['label' => '<i class="fa fa-heartbeat"></i>
                 กลุ่มรายงาน', 'url' => ['report/report']];
    $rpt_menu_g1[] = ['label' => '<i class="fa fa-heartbeat"></i> 
                รายงาน 2', 'url' => ['sqlscript/index']];
    $rpt_menu_g1[] = ['label' => '<i class="fa fa-heartbeat"></i> 
                รายงาน 3', 'url' => ['portal-qc/index']];
    $rpt_menu_g1[] = ['label' => '<i class="glyphicon glyphicon-retweet"></i> 
                รายงาน 4', 'url' => ['runquery/index']];
    $rpt_menu_g1[] = ['label' => '<i class="glyphicon glyphicon-floppy-saved"></i> 
                รายงาน 5', 'url' => ['site/download']];
    //End Menu group 1
    
    //Start Menu group 2
    $rpt_menu_g2[] = ['label' => '<i class="fa fa-heartbeat"></i> 
                DM Control', 'url' => ['report/dmctrl']];
    $rpt_menu_g2[] = ['label' => '<i class="fa fa-heartbeat"></i> 
                HT Control', 'url' => ['report/htctrl']];
    $rpt_menu_g2[] = ['label' => '<i class="fa fa-heartbeat"></i> 
                DM Screen 35+', 'url' => ['report/dmscramp']];
    $rpt_menu_g2[] = ['label' => '<i class="fa fa-heartbeat"></i> 
                HT Screen 35+', 'url' => ['report/htscramp']];
    $rpt_menu_g2[] = ['label' => '<i class="fa fa-heartbeat"></i> 
                DMHT Screen Kidney', 'url' => ['report/chscrkidneyamp']];
    $rpt_menu_g2[] = ['label' => '<i class="fa fa-heartbeat"></i> 
                --', 'url' => ['site/download']];
    //End Menu group 2
    
    //Start Menu group 3
    $rpt_menu_g3[] = ['label' => '<i class="glyphicon glyphicon-unchecked"></i>
                 รายงาน 1', 'url' => ['base-data/index']];
    $rpt_menu_g3[] = ['label' => '<i class="glyphicon glyphicon-list-alt"></i> 
                รายงาน 2', 'url' => ['sqlscript/index']];
    $rpt_menu_g3[] = ['label' => '<i class="glyphicon glyphicon-check"></i> 
                รายงาน 3', 'url' => ['portal-qc/index']];
    $rpt_menu_g3[] = ['label' => '<i class="glyphicon glyphicon-retweet"></i> 
                รายงาน 4', 'url' => ['runquery/index']];
    $rpt_menu_g3[] = ['label' => '<i class="glyphicon glyphicon-floppy-saved"></i> 
                รายงาน 5', 'url' => ['site/download']];
    //End Menu group 3
    
    //Start Menu group 4
    $rpt_menu_g4[] = ['label' => '<i class="glyphicon glyphicon-unchecked"></i>
                 รายงาน 1', 'url' => ['base-data/index']];
    $rpt_menu_g4[] = ['label' => '<i class="glyphicon glyphicon-list-alt"></i> 
                รายงาน 2', 'url' => ['sqlscript/index']];
    $rpt_menu_g4[] = ['label' => '<i class="glyphicon glyphicon-check"></i> 
                รายงาน 3', 'url' => ['portal-qc/index']];
    $rpt_menu_g4[] = ['label' => '<i class="glyphicon glyphicon-retweet"></i> 
                รายงาน 4', 'url' => ['runquery/index']];
    $rpt_menu_g4[] = ['label' => '<i class="glyphicon glyphicon-floppy-saved"></i> 
                รายงาน 5', 'url' => ['site/download']];
    //End Menu group 4
    
    //Start Menu group 5
    $rpt_menu_g5[] = ['label' => '<i class="glyphicon glyphicon-unchecked"></i>
                 รายงาน 1', 'url' => ['base-data/index']];
    $rpt_menu_g5[] = ['label' => '<i class="glyphicon glyphicon-list-alt"></i> 
                รายงาน 2', 'url' => ['sqlscript/index']];
    $rpt_menu_g5[] = ['label' => '<i class="glyphicon glyphicon-check"></i> 
                รายงาน 3', 'url' => ['portal-qc/index']];
    $rpt_menu_g5[] = ['label' => '<i class="glyphicon glyphicon-retweet"></i> 
                รายงาน 4', 'url' => ['runquery/index']];
    $rpt_menu_g5[] = ['label' => '<i class="glyphicon glyphicon-floppy-saved"></i> 
                รายงาน 5', 'url' => ['site/download']];
    //End Menu group 5
    
    $menuItems = [
        //['label' => 'Home', 'url' => ['/site/index']],
        //['label' => 'กลุ่มวัยที่ 1', 'items' => $rpt_menu_g1],
        ['label' => '<i class="fa fa-heartbeat"></i> NCD',  'items' => $rpt_menu_g2],
        //['label' => 'กลุ่มวัยที่ 3', 'items' => $rpt_menu_g3],
        //['label' => 'กลุ่มวัยที่ 4', 'items' => $rpt_menu_g4],
        //['label' => 'กลุ่มวัยที่ 5', 'items' => $rpt_menu_g5],
        //['label' => 'ติดต่อเรา', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'เข้าสู่ระบบ', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    /*
            $rpt_mnu_itms[] = ['label' => '<i class="glyphicon glyphicon-unchecked"></i>
                 ข้อมูลพื้นฐาน', 'url' => ['base-data/index']];
            $rpt_mnu_itms[] = ['label' => '<i class="glyphicon glyphicon-list-alt"></i> 
                รวมรายงาน', 'url' => ['sqlscript/index']];
            $rpt_mnu_itms[] = ['label' => '<i class="glyphicon glyphicon-check"></i> 
                คุณภาพการบันทึก', 'url' => ['portal-qc/index']];
            $rpt_mnu_itms[] = ['label' => '<i class="glyphicon glyphicon-retweet"></i> 
                คำสั่ง SQL', 'url' => ['runquery/index']];
            $rpt_mnu_itms[] = ['label' => '<i class="glyphicon glyphicon-floppy-saved"></i> 
                โปรแกรมตัดข้อมูล', 'url' => ['site/download']];
    $menuItems = [
                ['label' =>
                    '<i class="glyphicon glyphicon-list-alt"></i> กลุ่มวัยที่ 1',
                    'items' => $rpt_mnu_itms
                ],
            ];
    */
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => FALSE,
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
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>