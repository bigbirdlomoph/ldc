<?php
use miloschuman\highcharts\Highcharts;
use kartik\grid\GridView;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'DM Control ';
?>

<div class="col-md-12 col-xs-12" style="margin-top : 60px;">
    <h4 class="pull-left">ร้อยละผู้ป่วยโรคเบาหวานที่ควบคุมระดับน้ำตาลได้ดี</h4>
        <div class="pull-right">
            <a class="btn btn-small btn-success" href="<?= yii\helpers\Url::to(['report/report']) ?>">
            กลับ </a>
        </div>
    
    <div class="pull-right">
        <a class="dropdown dropdown-menu-left" href="<?= yii\helpers\Url::to(['report/report']) ?>">
           select
        </a>
    </div>
    <hr>
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
                            'headerOptions' => ['class' => 'text-center'],
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
                            'headerOptions' => ['class' => 'text-center'],
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
                            'headerOptions' => ['class' => 'text-center'],
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
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 't_mix_dx',
                            'header' => 'โรคประจำตัว',
                            'value' => function($data) {
                                return empty($data['t_mix_dx']) ? '-' : $data['t_mix_dx'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'rs_hba1c',
                            'header' => 'ผล HbA1c',
                            'value' => function($data) {
                                return empty($data['rs_hba1c']) ? '-' : $data['rs_hba1c'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'ld_hba1c',
                            'header' => 'วันที่ตรวจ HbA1c',
                            'value' => function($data) {
                                return empty($data['ld_hba1c']) ? '-' : $data['ld_hba1c'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'rs_fpg1',
                            'header' => 'ผลน้ำตาล #1',
                            'value' => function($data) {
                                return empty($data['rs_fpg1']) ? '-' : $data['rs_fpg1'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'ld_fpg1',
                            'header' => 'วันที่ตรวจ #1',
                            'value' => function($data) {
                                return empty($data['ld_fpg1']) ? '-' : $data['ld_fpg1'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'rs_fpg2',
                            'header' => 'ผลน้ำตาล #2',
                            'value' => function($data) {
                                return empty($data['rs_fpg2']) ? '-' : $data['rs_fpg2'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'ld_fpg2',
                            'header' => 'วันที่ตรวจ #2',
                            'value' => function($data) {
                                return empty($data['ld_fpg2']) ? '-' : $data['ld_fpg2'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'control_dm',
                            'header' => 'Ctrl',
                            'value' => function($data) {
                                return empty($data['control_dm']) ? '-' : $data['control_dm'];
                            }
                        ]
                         
                    ]
                ]);
                ?>
        </div>
    </div>

