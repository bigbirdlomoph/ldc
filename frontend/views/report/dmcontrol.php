<?php
use miloschuman\highcharts\Highcharts;
use kartik\grid\GridView;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = ':: DM Control ::';
?>
<div class="col-md-12 col-xs-12" style="margin-top : 80px;">
    <h4 class="pull-left">ร้อยละผู้ป่วยโรคเบาหวานที่ควบคุมระดับน้ำตาลได้ดี</h4>
       <div class="pull-right">      
        
        <div class="btn-group">
            <button type="button" class="btn btn-small btn-success" id="sel1">เลือกปีงบประมาณ</button>
            <button type="button" class="btn btn-small btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="true">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a href="<?= yii\helpers\Url::to(['report/dmcontrol','budget'=>2558]) ?>" type="submit">2558</a></li>
              <li><a href="<?= yii\helpers\Url::to(['report/dmcontrol','budget'=>2559]) ?>" type="submit">2559</a></li>
              <li><a href="<?= yii\helpers\Url::to(['report/dmcontrol','budget'=>2560]) ?>" type="submit">2560</a></li>
            </ul>
        </div>
        <a class="btn btn-small btn-success" href="<?= yii\helpers\Url::to(['report/dmcontrol']) ?>">
        กลับ </a>
        </div>
        
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


        <!--Table-->
        <div class="col-md-12 col-xs-12">
            <div id="chartdmcontrol">
                <?php
                    $sql = "$sql";
                    $rawData = Yii::$app->db->createCommand($sql)->queryAll();
                    $main_data=[];
                    //วน loop เก็บข้อมูล ลง Array
                    foreach ($rawData as $data) {
                            $main_data[] = [
                                'name' => $data['areaname'],
                                'y' => $data['p'] * 1,
                                //'drilldown' => $data['areacode']
                            ];
                    }
                    $main = json_encode($main_data)
                ?>

            <?php    
            $this->registerJs("$(function () {
                    // Create the chart
                    $('#chartdmcontrol').highcharts({
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
    <p> B หมายถึง จำนวนผู้ป่วยโรคเบาหวาน <br>
        A หมายถึง จำนวนผู้ป่วยโรคเบาหวานที่ควบคุมระดับน้ำตาลได้ดี</p>
    <!--Left Page-->
    <div class="col-md-12 col-xs-12">
        <div class="body-content">
            <?php
                if (isset($dataProvider))

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'hover' => TRUE,
                    'panel'=>['type'=>'primary', 
                        'heading'=>'ร้อยละผู้ป่วยโรคเบาหวานที่ควบคุมระดับน้ำตาลได้ดี'],
                    'summary'=>'',
                    'columns' => [
                        [
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:20px;'],
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'ลำดับที่'
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'areaname',
                            'header' => 'อำเภอ',
                            'format' => 'raw',
                            'value' => function($data) { 
                            $areacode = $data['areacode']; // ประกาศรับค่าตัวแปรจาก Controller
                            $areaname = $data['areaname']; // ประกาศรับค่าตัวแปรจาก Controller
                            return Html::a(Html::encode($areaname), ['/report/dmctrlhos', 'areacode' => $areacode]);
                            //return empty($data['areaname']) ? '-' : $data['areaname'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'target',
                            'header' => 'เป้าหมาย',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['target']) ? '-' : $data['target'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'result',
                            'header' => 'ผลงาน',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['result']) ? '-' : $data['result'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'p',
                            'header' => 'ร้อยละ',
                            'value' => function($data) {
                                return empty($data['p']) ? '-' : $data['p'];
                            }
                        ]
                    ]
                ]);
                ?>
        </div>
    </div>
</div>

