<?php
use miloschuman\highcharts\Highcharts;
use kartik\grid\GridView;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = ':: DMHT Screen Kidney :: ';
?>

<div class="col-md-12 col-xs-12" style="margin-top : 60px;">
    <h4 class="pull-left">ร้อยละของผู้ป่วย DM, HT ที่ได้รับการค้นหาและคัดกรองโรคไตเรื้อรัง</h4>
            <div class="pull-right">
            <a class="btn btn-small btn-success" href="<?= yii\helpers\Url::to(['report/chscrkidneyhos']) ?>">
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
                $sql = "SELECT ar_code AS areacode,
                        hosname, hoscode
                        ,SUM(target) as target 
                        ,SUM(result) as result
                        ,ROUND((sum(result))/(sum(target))*100,2) as p
                        ,SUM(result1) as resultq1
                        ,SUM(result2) as resultq2
                        ,SUM(result3) as resultq3
                        ,SUM(result4) as resultq4 
                        FROM s_kpi_ckd_screen 
                        LEFT JOIN ( 
                                        SELECT
                                        CONCAT(provcode,distcode,subdistcode) AS ar_code,
                                        hoscode,hosname,
                                        CONCAT(provcode,distcode,subdistcode) AS l_code
                                        FROM chospital
                                        WHERE hostype IN('03','06','07')
                                        GROUP BY l_code
                                        ORDER BY l_code
                        ) as ar ON left(s_kpi_ckd_screen.areacode,6)=ar.l_code
                        WHERE id = '0f6df79c2f8887f50d7879b5fe91c080' 
                        AND b_year = '2559' 
                        AND LEFT (areacode, 2) = '42'
                        AND LEFT (areacode, 4) = '4202'
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
                    'panel'=>['type'=>'primary', 
                        'heading'=>'ร้อยละของผู้ป่วย DM, HT ที่ได้รับการค้นหาและคัดกรองโรคไตเรื้อรัง'],
                    'summary'=>'',
                    'beforeHeader'=>[
                        [
                            'columns'=>[
                                ['content'=>'', 'options'=>['colspan'=>2, 'class'=>'text-center success']],
                                ['content'=>'รวม', 'options'=>['colspan'=>3, 'class'=>'text-center success']], 
                                ['content'=>'ไตรมาส 1', 'options'=>['colspan'=>2, 'class'=>'text-center info']], 
                                ['content'=>'ไตรมาส 2', 'options'=>['colspan'=>2, 'class'=>'text-center success']],
                                ['content'=>'ไตรมาส 3', 'options'=>['colspan'=>2, 'class'=>'text-center info']],
                                ['content'=>'ไตรมาส 4', 'options'=>['colspan'=>2, 'class'=>'text-center success']],
                            ],
                            'options'=>['class'=>'skip-export'] // remove this row from export
                        ]
                    ],
                    'columns' => [
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center success',],
                            'options' => ['style' => 'width:20px;'],
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'ลำดับที่'
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-left success'],
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
                            'contentOptions' => ['class' => 'text-center success'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'target',
                            'header' => 'B',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['target']) ? '-' : $data['target'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center success'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'result',
                            'header' => 'A',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['result']) ? '-' : $data['result'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center success'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'p',
                            'header' => '%',
                            'value' => function($data) {
                                return empty($data['p']) ? '-' : $data['p'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center info'],
                            'contentOptions' => ['class' => 'text-center info'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'resultq1',
                            'header' => 'จำนวน',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['resultq1']) ? '-' : $data['resultq1'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center info'],
                            'contentOptions' => ['class' => 'text-center info'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'pq1',
                            'header' => '%',
                            'value' => function($data) {
                                return empty($data['pq1']) ? '-' : $data['pq1'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center success'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'resultq2',
                            'header' => 'จำนวน',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['resultq2']) ? '-' : $data['resultq2'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center success'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'pq2',
                            'header' => '%',
                            'value' => function($data) {
                                return empty($data['pq2']) ? '-' : $data['pq2'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center info'],
                            'contentOptions' => ['class' => 'text-center info'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'resultq3',
                            'header' => 'จำนวน',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['resultq3']) ? '-' : $data['resultq3'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center info'],
                            'contentOptions' => ['class' => 'text-center info'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'pq3',
                            'header' => '%',
                            'value' => function($data) {
                                return empty($data['pq3']) ? '-' : $data['pq3'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center success'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'resultq4',
                            'header' => 'จำนวน',
                            //'format'=>['decimal', 0],
                            'format'=>'raw',
                            'value' => function($data) {
                                return empty($data['resultq4']) ? '-' : $data['resultq4'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center success'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'pq4',
                            'header' => '%',
                            'value' => function($data) {
                                return empty($data['pq4']) ? '-' : $data['pq4'];
                            }
                        ]
                    ]
                ]);
                ?>
        </div>
    </div>
</div>

