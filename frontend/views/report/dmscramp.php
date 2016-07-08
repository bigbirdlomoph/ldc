<?php
use miloschuman\highcharts\Highcharts;
use kartik\grid\GridView;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = ':: DM Screen ::';
?>
<div class="col-md-12 col-xs-12" style="margin-top : 80px;">
    <h4 class="pull-left">การคัดกรองเบาหวานในประชากรไทย อายุ 35 ปีขึ้นไป</h4>
       <div class="pull-right">      
        <?php $form = ActiveForm::begin([
                'id' => 'active-form',
                'action' => ['report/dmscramp'],
                'options' => [
                    'layout' => 'inline'
                ],
            ]); ?>
        <div class="btn-group">
            <button type="button" class="btn btn-small btn-success" id="sel1">เลือกปีงบประมาณ</button>
            <button type="button" class="btn btn-small btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="true">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a href="<?= yii\helpers\Url::to(['report/dmscramp','budget'=>2558]) ?>" type="submit">2558</a></li>
              <li><a href="<?= yii\helpers\Url::to(['report/dmscramp','budget'=>2559]) ?>" type="submit">2559</a></li>
              <li><a href="<?= yii\helpers\Url::to(['report/dmscramp','budget'=>2560]) ?>" type="submit">2560</a></li>
            </ul>
        </div>
        <a class="btn btn-small btn-success" href="<?= yii\helpers\Url::to(['report/dmscramp']) ?>">
        กลับ </a>
        </div>
        <?php ActiveForm::end(); ?>
    <hr>
</div>

        <div style="display: none">
            <?php
            $areacode = Yii::$app->request->post('areacode');
                echo Highcharts::widget([
                    'scripts' => [
                        'highcharts-more',
                        'modules/exporting',
                        'themes/grid',
                        //'modules/drilldown'
                    ]
                ]);
            ?>
        </div>

        <div class="col-md-12 col-xs-12">
                        
            <div id="charthtscramp">

                <?php
                $sql = "$sql";
                $rawData = Yii::$app->db->createCommand($sql)->queryAll();
                $main_data=[];
                //วน loop เก็บข้อมูล ลง Array
                foreach ($rawData as $data) {
                        $main_data[] = [
                            'name' => $data['areaname'],
                            'y' => $data['p3'] * 1,
                            //'drilldown' => $data['areacode']
                        ];
                }
                $main = json_encode($main_data)

            ?>

            <?php    
            $this->registerJs("$(function () {
                    // Create the chart
                    $('#charthtscramp').highcharts({
                chart: {
                    type : 'column',
                    borderWidth: 0,
                    borderRadius: 0,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                    options3d: {
                                enabled: true,
                                alpha: 45,
                                beta: 0
                }
                },
                title: {
                    text: '',
                    style : {
                                    fontFamily : 'Conv_ThaiSansNeue-Bold'
                            }
                },
                xAxis: {
                    type: 'category',
                    style : {
                                    fontFamily : 'Conv_ThaiSansNeue-Bold'
                            }
                },
                yAxis: {
                    title: {
                        text: 'ร้อยละ',
                        style : {
                                    fontFamily : 'Conv_ThaiSansNeue-Bold'
                            }
                    }
                },
                credits: {
                        enabled: false
                    },

                legend: {
                    enabled: true
                },

                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true
                        }
                    }
                },

                series: [{
                        name: 'ร้อยละ',
                            colorByPoint: true,
                            data: $main
                        }
                    ],
                    
                });
            });", yii\web\View::POS_END);
        ?>
            </div>
    </div>
    <p> A หมายถึง จำนวนประชากรไทย อายุ 35 ปี ได้รับการตรวจวัดระดับความด้นโลหิตในรอบปี<br>
        B หมายถึง จำนวนประชากรไทย อายุ 35 ปีขึ้นไป ที่ไม่ป่วยด้วยโรคความดันโลหิตสูง</p>
    <!--Left Page-->
    <div class="col-md-12 col-xs-12">
        <div class="body-content">
            <?php
                if (isset($dataProvider))

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'hover' => TRUE,
                    'panel'=>['type'=>'primary', 
                        'heading'=>'การคัดกรองความดันโลหิตสูง ในประชากรไทย อายุ 35 ปีขึ้นไป'],
                    'summary'=>'',
                    'beforeHeader'=>[
                        [
                            'columns'=>[
                                ['content'=>'', 'options'=>['colspan'=>2, 'class'=>'text-center success']],
                                ['content'=>'กลุ่มอายุ 15-34 ปี', 'options'=>['colspan'=>3, 'class'=>'text-center success']], 
                                ['content'=>'กลุ่มอายุ 35-59 ปี', 'options'=>['colspan'=>3, 'class'=>'text-center success']], 
                                ['content'=>'กลุ่มอายุ 60 ปีขึ้นไป', 'options'=>['colspan'=>3, 'class'=>'text-center success']], 
                            ],
                            'options'=>['class'=>'skip-export'] // remove this row from export
                        ]
                    ],
                    'columns' => [
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center',],
                            'options' => ['style' => 'width:20px;'],
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'ลำดับที่'
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-left'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'areaname',
                            'header' => 'อำเภอ',
                            'format' => 'raw',
                            'value' => function($data) { 
                                $areacode = $data['areacode']; // ประกาศรับค่าตัวแปรจาก Controller
                                $areaname = $data['areaname']; // ประกาศรับค่าตัวแปรจาก Controller
                            return Html::a(Html::encode($areaname), ['/report/htscrhos', 'areacode' => $areacode]);
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'target2',
                            'header' => 'B',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['target2']) ? '-' : $data['target2'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'result2',
                            'header' => 'A',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['result2']) ? '-' : $data['result2'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'p2',
                            'header' => '%',
                            'value' => function($data) {
                                return empty($data['p2']) ? '-' : $data['p2'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'target3',
                            'header' => 'B',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['target3']) ? '-' : $data['target3'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'result3',
                            'header' => 'A',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['result3']) ? '-' : $data['result3'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'p3',
                            'header' => '%',
                            'value' => function($data) {
                                return empty($data['p3']) ? '-' : $data['p3'];
                            }
                        ],
                                [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'target4',
                            'header' => 'B',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['target4']) ? '-' : $data['target4'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'result4',
                            'header' => 'A',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['result4']) ? '-' : $data['result4'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'p4',
                            'header' => '%',
                            'value' => function($data) {
                                return empty($data['p4']) ? '-' : $data['p4'];
                            }
                        ]
                    ]
                ]);
                ?>
        </div>
    </div>
</div>

