<?php
use miloschuman\highcharts\Highcharts;
use kartik\grid\GridView;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = ':: DMHT Screen Kidney ::';
?>

<div class="col-md-12 col-xs-12" style="margin-top : 60px;">
    <h4 class="pull-left">ร้อยละของผู้ป่วย DM, HT ที่ได้รับการค้นหาและคัดกรองโรคไตเรื้อรัง</h4>
        <div class="pull-right">
            <a class="btn btn-small btn-success" href="<?= yii\helpers\Url::to(['report/chscrkidneyamp']) ?>">
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
        ]);?>
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
        <button class='btn btn-success' href="<?= yii\helpers\Url::to(['report/chscrkidneyhos']) ?>" type="submit">ประมวลผล</button>
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
                    'panel'=>['type'=>'primary', 'heading'=>'ร้อยละของผู้ป่วย DM, HT ที่ได้รับการค้นหาและคัดกรองโรคไตเรื้อรัง'],
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
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:20px;'],
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
                            //'options' => ['style' => 'width:20px;'],
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
                            //'options' => ['style' => 'width:10px;'],
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
                            //'options' => ['style' => 'width:10px;'],
                            'attribute' => 'sex',
                            'header' => 'เพศ',
                            'value' => function($data) {
                                return empty($data['sex']) ? '-' : $data['sex'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            //'options' => ['style' => 'width: 30px;'],
                            'attribute' => 'mix_dx',
                            'header' => 'Diag',
                            'value' => function($data) {
                                return empty($data['mix_dx']) ? '-' : $data['mix_dx'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            //'options' => ['style' => 'width:50px;'],
                            'attribute' => 'minlab_date',
                            'header' => 'วันที่ตรวจ LAB ครั้งแรก',
                            'value' => function($data) {
                                return empty($data['minlab_date']) ? '-' : $data['minlab_date'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center info'],
                            'contentOptions' => ['class' => 'text-center'],
                            //'options' => ['style' => 'width:30px;'],
                            'attribute' => 'lab11_result',
                            'header' => 'ผล Cretinine',
                            'value' => function($data) {
                                return empty($data['lab11_result']) ? '-' : $data['lab11_result'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center info'],
                            'contentOptions' => ['class' => 'text-center'],
                            //'options' => ['style' => 'width:30px;'],
                            'attribute' => 'lab11_date',
                            'header' => 'วันที่ตรวจ Cretinine',
                            'value' => function($data) {
                                return empty($data['lab11_date']) ? '-' : $data['lab11_date'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center info'],
                            'contentOptions' => ['class' => 'text-center'],
                            //'options' => ['style' => 'width:30px;'],
                            'attribute' => 'lab11_hosp',
                            'header' => 'รพ. ที่ตรวจ LAB',
                            'value' => function($data) {
                                return empty($data['lab11_hosp']) ? '-' : $data['lab11_hosp'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            //'options' => ['style' => 'width:30px;'],
                            'attribute' => 'lab15_result',
                            'header' => 'eGFR (ใช้สูตร CKD-EPI formula)',
                            'value' => function($data) {
                                return empty($data['lab15_result']) ? '-' : $data['lab15_result'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            //'options' => ['style' => 'width:30px;'],
                            'attribute' => 'lab15_date',
                            'header' => 'วันที่ตรวจ microalbumin',
                            'value' => function($data) {
                                return empty($data['lab15_date']) ? '-' : $data['lab15_date'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            //'options' => ['style' => 'width:30px;'],
                            'attribute' => 'lab15_hosp',
                            'header' => 'รพ. ที่ตรวจ LAB',
                            'value' => function($data) {
                                return empty($data['lab15_hosp']) ? '-' : $data['lab15_hosp'];
                            }
                        ],
                    ]
                ]);
                ?>
        </div>
        <p>    หมายเหตุ :: <br>
                B = ผู้ป่วยโรคเบาหวานและหรือความดันโลหิตสูงสัญชาติไทย ในเขตรับผิดชอบที่ไม่มีภาวะแทรกซ้อนทางไต<br>
                <br>
                   ประมวลผลจาก ผู้ป่วยรหัสโรคเป็น (E10* ถึง E14*) ลบออกด้วย (E102, E112, E122, E132, E142) <br>
                และ/หรือ มีรหัสโรคเป็น (I10* ถึง I15*) ลบออกด้วย (I12*, I13*,I151) และไม่มีรหัสโรค N181-189 <br>
                ******ผู้ป่วยที่มีภาวะแทรกซ้อนก่อนปีงบประมาณปัจจุบัน จึงจะนำมาหักออกเท่านั้น<br>
                <br>
                A = ผู้ป่วยตาม B ที่ได้รับการตรวจคัดกรอง คือ ตรวจ LABTEST12 หรือ LABTEST14 หรือ LABTEST11 หรือ LABTEST15<br>
                <br>
                โดยประเมินจากวันที่ตรวจในปีงบประมาณเท่านั้น (ไม่ดูผลการตรวจ)<br>
                *******หากมีการตรวจ LAB มากกว่าหนึ่งรายการ จะนับเป็นผลงานในไตรมาสที่วันที่ตรวจน้อยที่สุดเพียงครั้งเดียวเท่านั้น<br>

                +++ใช้แฟ้ม Chronic,Diagnosis_OPD ,Diagnosis_IPD,LABFU , Person และ Home ประมวลผล) </p>
        <?php print_r($date1); ?>
        <?php print_r($date2); ?>
    </div>

