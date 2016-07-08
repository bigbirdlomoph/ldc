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
    <hr>
</div>
    <!--Right Page-->
        <div style="display: none">
            <?php
                echo Highcharts::widget([
                    'scripts' => [
                        'highcharts-more',
                        'modules/exporting',
                        'themes/grid',
                        'modules/drilldown'
                    ]
                ]);
            ?>
        </div>
        <div class="col-md-12 col-xs-12">
            <div id="chartdmcontrol">

                <?php
                $sql = "SELECT  ar_code AS areacodehos,
                                hosname,
                                sum(target) AS target,
                                sum(result) AS result,
                                ROUND((sum(result) / sum(target)) * 100,2) AS p
                        FROM s_dm_control
                        LEFT JOIN (
                                SELECT
                                CONCAT(provcode,distcode,subdistcode) AS ar_code,
                                hoscode, hosname,
                                CONCAT(provcode,distcode,subdistcode) AS l_code
                                FROM chospital
                                WHERE hostype IN('03','06','07')
                                GROUP BY l_code
                                ORDER BY l_code
                        ) AS ar ON LEFT (s_dm_control.areacode, 6) = ar.l_code
                        WHERE id = '137a726340e4dfde7bbbc5d8aeee3ac3'
                        AND b_year = '2559'
                        AND LEFT (areacode, 2) = '42'
                        AND LEFT (areacode, 4) = '$areacode'
                        GROUP BY ar.ar_code";
                $rawData = Yii::$app->db->createCommand($sql)->queryAll();
                $main_data=[];
                //วน loop เก็บข้อมูล ลง Array
                foreach ($rawData as $data) {
                        $main_data[] = [
                            'name' => $data['hosname'],
                            'y' => $data['p'] * 1,
                            //'drilldown' => $data['areacodetam']
                        ];
                }
                $main = json_encode($main_data);
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
            <!--<?php print_r($areacode); ?>-->
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
                    'panel'=>['type'=>'primary', 'heading'=>'เบาหวานควบคุมน้ำตาลได้'],
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
                            'contentOptions' => ['class' => 'text-left'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'hosname',
                            'header' => 'หน่วยบริการ',
                            'format' => 'raw',
                            'value' => function($data) { 
                                $areacodehos = Yii::$app->request->post('areacodehos');  
                                $hosname = Yii::$app->request->post('hosname'); 
                                $hoscode = Yii::$app->request->post('hoscode');
                            return Html::a($data['hosname'], ['/report/dmctrlpid','hoscode' => $data['hoscode'],
                                'areacodehos' => $data['areacodehos']]);
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

