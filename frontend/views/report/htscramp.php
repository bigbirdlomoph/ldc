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
<div class="col-md-12 col-xs-12" style="margin-top : 80px;">
    <h4 class="pull-left">การคัดกรองความดันโลหิตสูง ในประชากรไทย อายุ 35 ปีขึ้นไป</h4>
       <div class="pull-right">
           <!--<?php $form = ActiveForm::begin([
                'id' => 'active-form',
                'action' => ['controller/action'],
                'options' => [
                    'layout' => 'inline'
                ],
            ]); ?>
            <div class="pull-right">
                <div class="form-group pull-right">
                    <div class="row">
                        <div class="col-md-3"><label for="sel1">ปีงบประมาณ:</label></div>
                        <div class="col-md-6">
                            <select class="form-control" name="name" id="sel1">
                                <option value="">--เลือกปีงบประมาณ--</option>
                                <option value="2014-10-01' AND '2015-09-30" href="<?= yii\helpers\Url::to(['report/htctrl']) ?>">2558</option>
                                <option value="2015-10-01' AND '2016-09-30" href="<?= yii\helpers\Url::to(['report/htctrl']) ?>">2559</option>
                                <option value="2016-10-01' AND '2017-09-30" href="<?= yii\helpers\Url::to(['report/htctrl']) ?>">2560</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-small btn-success" href="<?= yii\helpers\Url::to(['report/htctrl']) ?>" type="submit">ตกลง </a>
                            <a class="btn btn-small btn-success" href="<?= yii\helpers\Url::to(['report/htctrl']) ?>">กลับ </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?> -->
           
        
        <?php $form = ActiveForm::begin([
                'id' => 'active-form',
                'action' => ['controller/action'],
                'options' => [
                    'layout' => 'inline'
                ],
            ]); ?>
        <div class="btn-group">
            <button type="button" class="btn btn-small btn-success">เลือกปีงบประมาณ</button>
            <button type="button" class="btn btn-small btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="true">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a value="2014-10-01' AND '2015-09-30" href="<?= yii\helpers\Url::to(['report/htctrl']) ?>" type="submit">2558</a></li>
              <li><a value="2015-10-01' AND '2016-09-30" href="<?= yii\helpers\Url::to(['report/htctrl']) ?>" type="submit">2559</a></li>
              <li><a value="2016-10-01' AND '2017-09-30" href="<?= yii\helpers\Url::to(['report/htctrl']) ?>" type="submit">2560</a></li>
            </ul>
        </div>
        <a class="btn btn-small btn-success" href="<?= yii\helpers\Url::to(['report/htctrl']) ?>">
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
                $sql = "SELECT 
                        ar_code as areacode
                        ,ar_name as areaname 
                        ,SUM(result_group2) as result2 ,SUM(result_group3) as result3 ,SUM(result_group4) as result4 
                        ,SUM(pop_group2) as target2 ,SUM(pop_group3) as target3 ,SUM(pop_group4) as target4
                        ,ROUND(((SUM(result_group2)) /(SUM(pop_group2)) *100),2) as p2
                        ,ROUND(((SUM(result_group3)) /(SUM(pop_group3)) *100),2) as p3
                        ,ROUND(((SUM(result_group4)) /(SUM(pop_group4)) *100),2) as p4 
                        FROM s_ht_screen_pop_age 
                        LEFT JOIN ( 
                                    SELECT 
                                    ampurcodefull as ar_code,ampurname as ar_name,ampurcodefull as l_code 
                                    FROM campur 
                                    GROUP BY l_code	
                                    ORDER BY l_code 
                        ) as ar ON left(s_ht_screen_pop_age.areacode,4)=ar.l_code
                        WHERE id = '68e401815a64e624c286d97ef3582aa3' 
                        AND b_year = '2559' 
                        AND left(areacode,2)='42' 
                        GROUP BY ar_code";
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
                            return empty($data['areaname']) ? '-' : $data['areaname'];
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

