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
<div class="col-md-12 col-xs-12" style="margin-top : 80px;">
    <h4 class="pull-left">ร้อยละของผู้ป่วย DM, HT ที่ได้รับการค้นหาและคัดกรองโรคไตเรื้อรัง</h4>
       <div class="pull-right">
       <?php $form = ActiveForm::begin([
                'id' => 'active-form',
                'action' => ['report/chscrkidneyamp'],
                'options' => [
                    'layout' => 'inline'
                ],
            ]); ?>
        <div class="btn-group" method="POST">
            <button type="button" class="btn btn-small btn-success">เลือกปีงบประมาณ</button>
            <button type="button" class="btn btn-small btn-success dropdown-toggle" data-toggle="dropdown" 
                    aria-haspopup="false" aria-expanded="true">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a name="budget" value="2558" href="<?= yii\helpers\Url::to(['report/chscrkidneyamp']) ?>" type="submit">2558</a></li>
              <li><a name="budget" value="2559" href="<?= yii\helpers\Url::to(['report/chscrkidneyamp']) ?>" type="submit">2559</a></li>
              <li><a name="budget" value="2560" href="<?= yii\helpers\Url::to(['report/chscrkidneyamp']) ?>" type="submit">2560</a></li>
            </ul>
        </div>
            <a class="btn btn-small btn-success" href="<?= yii\helpers\Url::to(['report/chscrkidneyamp']) ?>">
                กลับ </a>
        </div>
        <?php ActiveForm::end(); ?> 

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
                        <select class="form-control" name="budget" id="sel1">
                            <option value="">--เลือกปีงบประมาณ--</option>
                            <option value="2558">2558</option>
                            <option value="2559">2559</option>
                            <option value="2560">2560</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-small btn-success" href="<?= yii\helpers\Url::to(['report/chscrkidneyamp']) ?>">กลับ </button>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>-->
        
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
                            'y' => $data['p'] * 1,
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
                        'heading'=>'ร้อยละของผู้ป่วย DM, HT ที่ได้รับการค้นหาและคัดกรองโรคไตเรื้อรัง'],
                    'summary'=>'',
                    'beforeHeader'=>[
                        [
                            'columns'=>[
                                ['content'=>'', 'options'=>['colspan'=>2, 'class'=>'text-center success']],
                                ['content'=>'รวม', 'options'=>['colspan'=>3, 'class'=>'text-center success']], 
                                ['content'=>'ไตรมาส 1', 'options'=>['colspan'=>2, 'class'=>'text-center success']], 
                                ['content'=>'ไตรมาส 2', 'options'=>['colspan'=>2, 'class'=>'text-center success']],
                                ['content'=>'ไตรมาส 3', 'options'=>['colspan'=>2, 'class'=>'text-center success']],
                                ['content'=>'ไตรมาส 4', 'options'=>['colspan'=>2, 'class'=>'text-center success']],
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
                            return Html::a(Html::encode($areaname), ['/report/chscrkidneyhos', 'areacode' => $areacode]);
                            return empty($data['areaname']) ? '-' : $data['areaname'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
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
                            'contentOptions' => ['class' => 'text-center'],
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
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'p',
                            'header' => '%',
                            'value' => function($data) {
                                return empty($data['p']) ? '-' : $data['p'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'resultq1',
                            'header' => 'จำนวน',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['resultq1']) ? '-' : $data['resultq1'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'pq1',
                            'header' => '%',
                            'value' => function($data) {
                                return empty($data['pq1']) ? '-' : $data['pq1'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
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
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'pq2',
                            'header' => '%',
                            'value' => function($data) {
                                return empty($data['pq2']) ? '-' : $data['pq2'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'resultq3',
                            'header' => 'จำนวน',
                            'format'=>['decimal', 0],
                            'value' => function($data) {
                                return empty($data['resultq3']) ? '-' : $data['resultq3'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
                            'options' => ['style' => 'width:30px;'],
                            'attribute' => 'pq3',
                            'header' => '%',
                            'value' => function($data) {
                                return empty($data['pq3']) ? '-' : $data['pq3'];
                            }
                        ],
                        [
                            'headerOptions' => ['class' => 'text-center success'],
                            'contentOptions' => ['class' => 'text-center'],
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
                            'contentOptions' => ['class' => 'text-center'],
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

