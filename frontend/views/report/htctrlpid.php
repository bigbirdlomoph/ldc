<?php
use miloschuman\highcharts\Highcharts;
use kartik\grid\GridView;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = ':: HT Control ::';
?>

<div class="col-md-12 col-xs-12" style="margin-top : 60px;">
    <h4 class="pull-left">ร้อยละผู้ป่วยโรคความดันโลหิตสูงที่ควบคุมความดันฯ ได้ดี</h4>
        <div class="pull-right">
            <a class="btn btn-small btn-success" href="<?= yii\helpers\Url::to(['report/htctrl']) ?>">
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
                    'panel'=>['type'=>'primary', 'heading'=>'ผู้ป่วยเบาหวานควบคุมน้ำตาลได้ดี'],
                    'summary'=>'',
                    'columns' => [
                        [
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:10px;'],
                            'class' => 'yii\grid\SerialColumn',
                            'header' => '#'
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'Target',
                            'header' => 'กลุ่ม',
                            'format' => 'raw',
                            'value' => function($data) { 
                                return empty($data['Target']) ? '-' : $data['Target'];
                            }
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
                            'attribute' => 't_mix_dx',
                            'header' => 'โรคประจำตัว',
                            'value' => function($data) {
                                return empty($data['t_mix_dx']) ? '-' : $data['t_mix_dx'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'rs_bps1',
                            'header' => 'BPS #1',
                            'value' => function($data) {
                                return empty($data['rs_bps1']) ? '-' : $data['rs_bps1'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'rs_bpd1',
                            'header' => 'BPD #1',
                            'value' => function($data) {
                                return empty($data['rs_bpd1']) ? '-' : $data['rs_bpd1'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'ld_bp1',
                            'header' => 'วันที่วัด bps/bpd #1',
                            'value' => function($data) {
                                return empty($data['ld_bp1']) ? '-' : $data['ld_bp1'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'rs_bps2',
                            'header' => 'BPS #2',
                            'value' => function($data) {
                                return empty($data['rs_bps2']) ? '-' : $data['rs_bps2'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'rs_bpd2',
                            'header' => 'BPD #2',
                            'value' => function($data) {
                                return empty($data['rs_bpd2']) ? '-' : $data['rs_bpd2'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'ld_bp2',
                            'header' => 'วันที่วัด bps/bpd #2',
                            'value' => function($data) {
                                return empty($data['ld_bp2']) ? '-' : $data['ld_bp2'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'control_ht',
                            'header' => 'Ctrl',
                            'value' => function($data) {
                                return empty($data['control_ht']) ? '-' : $data['control_ht'];
                            }
                        ]
                         
                    ]
                ]);
                ?>
        </div>
        <?php print_r($date1); ?>
        <?php print_r($date2); ?>
    </div>

