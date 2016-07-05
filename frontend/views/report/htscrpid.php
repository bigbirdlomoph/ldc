<?php
use miloschuman\highcharts\Highcharts;
use kartik\grid\GridView;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = ':: HT Screen ::';
?>

<div class="col-md-12 col-xs-12" style="margin-top : 60px;">
    <h4 class="pull-left">การคัดกรองความดันโลหิตสูง ในประชากรไทย อายุ 35 ปีขึ้นไป</h4>
        <div class="pull-right">
            <a class="btn btn-small btn-success" href="<?= yii\helpers\Url::to(['report/htscramp']) ?>">
            กลับ </a>
        </div>
    <hr>
</div>

<div class='well well-sm'>
    <form method="POST">
        ระหว่าง:
        <?php
    //    echo Yii::$app->formatter->asDate(time(), 'short');
        echo yii\jui\DatePicker::widget([
            'name' => 'date1',
            'value' => $date1,
            'language' => 'th',
            'dateFormat' => 'dd-MM-yyyy', 
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
     
            ],
        ]);
        ?>
        ถึง:
        <?php
        echo yii\jui\DatePicker::widget([
            'name' => 'date2',
            'value' =>  date('Y-m-d'),
            'language' => 'th',
            'dateFormat' => 'dd-MM-yyyy',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
            ]
        ]);
        ?>
        <button class='btn btn-success' href="<?= yii\helpers\Url::to(['report/htctrl']) ?>" type="submit">ประมวลผล</button>
    </form>
</div>

    <!--Left Page-->
    <div class="col-md-12 col-xs-12">
        <div class="body-content">
            <?php
                if (isset($dataProvider))
                                
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'hover' => TRUE,
                    'panel'=>['type'=>'primary', 'heading'=>'การคัดกรองความดันโลหิตสูง ในประชากรไทย อายุ 35 ปีขึ้นไป'],
                    'summary'=>'',
                    'columns' => [
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:10px;'],
                            'class' => 'yii\grid\SerialColumn',
                            'header' => '#'
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-left'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'hospcode',
                            'header' => 'รหัสสถานพยาบาล',
                            'format' => 'raw',
                            'value' => function($data) { 
                                return empty($data['hospcode']) ? '-' : $data['hospcode'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:20px;'],
                            'attribute' => 'pid',
                            'header' => 'PID',
                            'format'=>'raw',
                            'value' => function($data) {
                                return empty($data['pid']) ? '-' : $data['pid'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:10px;'],
                            'attribute' => 'age_y',
                            'header' => 'อายุ',
                            'format'=>'raw',
                            'value' => function($data) {
                                return empty($data['age_y']) ? '-' : $data['age_y'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'date_screen',
                            'header' => 'วันที่คัดกรอง',
                            'value' => function($data) {
                                return empty($data['date_screen']) ? '-' : $data['date_screen'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'sbp',
                            'header' => 'SBP',
                            'value' => function($data) {
                                return empty($data['sbp']) ? '-' : $data['sbp'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'dbp',
                            'header' => 'DBP',
                            'value' => function($data) {
                                return empty($data['dbp']) ? '-' : $data['dbp'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'sbp_1',
                            'header' => 'SBP #1',
                            'value' => function($data) {
                                return empty($data['sbp_1']) ? '-' : $data['sbp_1'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'dbp_1',
                            'header' => 'DBP #1',
                            'value' => function($data) {
                                return empty($data['dbp_1']) ? '-' : $data['dbp_1'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'sbp_2',
                            'header' => 'SBP #2',
                            'value' => function($data) {
                                return empty($data['sbp_2']) ? '-' : $data['sbp_2'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'dbp_2',
                            'header' => 'DBP #2',
                            'value' => function($data) {
                                return empty($data['dbp_2']) ? '-' : $data['dbp_2'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center warning'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'risk',
                            'header' => 'กลุ่มเสี่ยง',
                            'value' => function($data) {
                                return empty($data['risk']) ? '-' : $data['risk'];
                            }
                        ]
                         
                    ]
                ]);
                ?>
        </div>
        <?php print_r($date1); ?>
        <?php print_r($date2); ?>
    </div>

