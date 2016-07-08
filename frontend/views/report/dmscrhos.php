<?php
use miloschuman\highcharts\Highcharts;
use kartik\grid\GridView;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = ':: HT Screen Hospital :: ';
?>

<div class="col-md-12 col-xs-12" style="margin-top : 60px;">
    <h4 class="pull-left">การคัดกรองความดันโลหิตสูง ในประชากรไทย อายุ 35 ปีขึ้นไป</h4>
            <div class="pull-right">
            <a class="btn btn-small btn-success" href="<?= yii\helpers\Url::to(['report/htscramp']) ?>">
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
            <div id="charthtscrhos">
                <?php
                $sql = "SELECT ar_code AS areacodehos,
                        hosname,
                        hoscode
                        ,SUM(result_group2) as result2 ,SUM(result_group3) as result3 ,SUM(result_group4) as result4 
                        ,SUM(pop_group2) as target2 ,SUM(pop_group3) as target3 ,SUM(pop_group4) as target4
                        ,ROUND(((SUM(result_group2)) /(SUM(pop_group2)) *100),2) as p2
                        ,ROUND(((SUM(result_group3)) /(SUM(pop_group3)) *100),2) as p3
                        ,ROUND(((SUM(result_group4)) /(SUM(pop_group4)) *100),2) as p4 
                FROM s_ht_screen_pop_age 
                LEFT JOIN ( 
                            SELECT
                            CONCAT(provcode,distcode,subdistcode) AS ar_code,
                            hoscode,
                            hosname,
                            CONCAT(provcode,distcode,subdistcode) AS l_code
                            FROM chospital
                            WHERE hostype IN('03','06','07')
                            GROUP BY l_code
                            ORDER BY l_code
                        ) as ar ON left(s_ht_screen_pop_age.areacode,6)=ar.l_code
                WHERE id = '68e401815a64e624c286d97ef3582aa3' 
                AND b_year = '2559' 
                AND left(areacode,2)='42' 
                AND LEFT (areacode, 4) = '$areacode'
                GROUP BY ar.ar_code";
                $rawData = Yii::$app->db->createCommand($sql)->queryAll();
                $main_data=[];
                //วน loop เก็บข้อมูล ลง Array
                foreach ($rawData as $data) {
                        $main_data[] = [
                            'name' => $data['hosname'],
                            'y' => $data['p3'] * 1,
                            //'drilldown' => $data['areacodetam']
                        ];
                }
                $main = json_encode($main_data);
                ?>

                <?php    
                $this->registerJs("$(function () {
                    // Create the chart
                    $('#charthtscrhos').highcharts({
                    chart: {
                            type : 'column',
                            borderWidth: 0,
                            borderRadius: 0,
                            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#FFF',
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
    <!--Left Page-->
    <div class="col-md-12 col-xs-12" style="margin-top: 10px;">
        <div class="body-content">
            <?php
                if (isset($dataProvider))
                                
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'hover' => TRUE,
                    'panel'=>['type'=>'primary', 'heading'=>'การคัดกรองความดันโลหิตสูง ในประชากรไทย อายุ 35 ปีขึ้นไป'],
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
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:20px;'],
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'ลำดับที่'
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-left'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'hosname',
                            'header' => 'หน่วยบริการ',
                            'format' => 'raw',
                            'value' => function($data) { 
                                $areacodehos = Yii::$app->request->post('areacodehos');  
                                $hosname = Yii::$app->request->post('hosname'); 
                                $hoscode = Yii::$app->request->post('hoscode');
                            return Html::a($data['hosname'], ['/report/htscrpid','hoscode' => $data['hoscode'],
                                'areacodehos' => $data['areacodehos']]);
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'target2',
                            'header' => 'B',
                            //'format'=>['decimal', 0],
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
                            //'format'=>['decimal', 0],
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
                            'contentOptions' => ['class' => 'text-center info'],
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
                            'contentOptions' => ['class' => 'text-center warning'],
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

