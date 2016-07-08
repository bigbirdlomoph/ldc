<?php
/* @var $this yii\web\View */

use miloschuman\highcharts\Highcharts;
use kartik\grid\GridView;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\models\Cbyear;

$this->title = 'Loei HDC';
?>
<div class="site-index" style="margin-top: 80px">
    <div class="col-sm-12">

        <!-- solid gauge 1 -->
        <div class="panel-body">
            <div style="display: none">
                <?php
                echo Highcharts::widget([
                    'scripts' => [
                        'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'modules/solid-gauge',
                        //'modules/exporting', // adds Exporting button/menu to chart
                        'themes/grid'        // applies global 'grid' theme to all charts
                    ]
                ]);
                ?>
            </div>
            <!--<div style="width: 700px; height: 500px; margin: 0 auto">
            <div id="solidgauge1" style="width: 350px; height: 250px; float: left"><?php
                $charttitle = "ร้อยละผู้ป่วยโรคเบาหวานที่ควบคุมระดับน้ำตาลได้ดี";?>
                </div>
            <div id="solidgauge2" style="width: 350px; height: 250px; float: left"><?php 
                $charttitle2 = "ร้อยละผู้ป่วยโรคความดันโลหิตสูงที่ควบคุมความดันโลหิตได้ดี";?>
                </div>
            </div>-->
            <div class="col-md-12 col-xs-12" style="margin-top : 0 auto">
                <div id="solidgauge1" class="col-md-6 col-xs-4" style="height: 250px; float: left"><?php
                $charttitle = "ร้อยละผู้ป่วยโรคเบาหวานที่ควบคุมระดับน้ำตาลได้ดี";?>
                </div>
            <div id="solidgauge2" class="col-md-6 col-xs-4" style="height: 250px; float: left"><?php 
                $charttitle2 = "ร้อยละผู้ป่วยโรคความดันโลหิตสูงที่ควบคุมความดันฯได้ดี";?>
                </div>
            </div>
            <?php
            //$charttitle = "ร้อยละผู้ป่วยโรคเบาหวานที่ควบคุมระดับน้ำตาลได้ดี";
            //$charttitle2 = "ร้อยละผู้ป่วยโรคความดันโลหิตสูงที่ควบคุมความดันโลหิตได้ดี";
            $sql = Yii::$app->db->createCommand(
                    "SELECT ROUND((sum(result)/sum(target))*100,2) as total 
                    FROM s_dm_control 
                    LEFT JOIN ( 
                    SELECT	
                        ampurcodefull as ar_code, 
                        ampurname as ar_name,
                        ampurcodefull as l_code 
                    FROM campur 
                        GROUP BY l_code	
                        ORDER BY l_code 
                        ) as ar ON left(s_dm_control.areacode,4)=ar.l_code
                        WHERE id = '137a726340e4dfde7bbbc5d8aeee3ac3' AND b_year = '2559' AND left(areacode,2)='42' "
                    )->queryScalar();
            $sql2 = Yii::$app->db->createCommand(
                    "SELECT 
                    ROUND((sum(result)/sum(target))*100,2) as total 
                    FROM s_ht_control 
                    LEFT JOIN ( 
                            SELECT ampurcodefull as ar_code,ampurname as ar_name,ampurcodefull as l_code 
                            FROM campur 
                            GROUP BY l_code	
                            ORDER BY l_code 
                    ) as ar ON left(s_ht_control.areacode,4)=ar.l_code
                    WHERE id = '2e3813337b6b5377c2f68affe247d5f9' AND b_year = '2559' AND left(areacode,2)='42' "
                    )->queryScalar();
            
            $this->registerJs(" $(function () {
                    var gaugeOptions = {

                    chart: {
                        type: 'solidgauge',
                        borderWidth: 0,
                        borderRadius: 10,
                    },

                    title: {
                        text : ''
                    },

                    pane: {
                        center: ['50%', '75%'],
                        size: '85%', //ขนาดของ Gauge
                        startAngle: -90,
                        endAngle: 90,
                        background: {
                            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#DDD',
                            innerRadius: '60%',
                            outerRadius: '100%',
                            shape: 'arc'
                        }
                    },

                    tooltip: {
                        enabled: false
                    },

                    // the value axis
                    yAxis: {
                        stops: [
                            [100, '#55BF3B'], // green
                            [85, '#DDDF0D'], // yellow
                            [0, '#DF5353'] // red
                        ],
                        lineWidth: 0,
                        minorTickInterval: null,
                        tickPixelInterval: 400,
                        tickWidth: 0,

                        title: {
                            y: -70
                        },
                        labels: {
                            y: 16
                        }
                    },

                    plotOptions: {
                        solidgauge: {
                            dataLabels: {
                                y: 5,
                                borderWidth: 0,
                                useHTML: true
                            }
                        }
                    }
                };

                // solidgauge1
                $('#solidgauge1').highcharts(Highcharts.merge(gaugeOptions, {
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: '$charttitle'
                        }
                    },

                    credits: {
                        enabled: false
                    },

                    series: [{
                        name: ' ',
                        data: [$sql],
                        dataLabels: {
                            format: ['$sql %'],
                        },
                        tooltip: {
                            valueSuffix: ' %'
                        }
                    }]

                }));
                //End solidgauge 1//
                
                // solidgauge2
                $('#solidgauge2').highcharts(Highcharts.merge(gaugeOptions, {
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: '$charttitle2'
                        }
                    },
                    
                    credits: {
                        enabled: false
                    },

                    series: [{
                        name: '',
                        data: [['ร้อยละ',$sql2]],
                        dataLabels: {
                            format: ['$sql2 %']
                        },
                        tooltip: {
                            valueSuffix: ' %'
                        }
                    }]
                }));
                
            });
        ");?>
        </div>
        <!--End Gauge DMHT Control-->
        
        <!--Start Gauge Screen CKD-->
        <div class="panel-body">
            <div style="display: none">
                <?php
                echo Highcharts::widget([
                    'scripts' => [
                        'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'modules/solid-gauge',
                        //'modules/exporting', // adds Exporting button/menu to chart
                        'themes/grid'        // applies global 'grid' theme to all charts
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-12 col-xs-12" style="margin-top : 0 auto">
                <div id="solidgauge3" class="col-md-6 col-xs-4" style="height: 250px; float: left"><?php 
                $charttitle3 = "ร้อยละของผู้ป่วย DM, HT ที่ได้รับการค้นหาและคัดกรองโรคไตเรื้อรัง";?>
                </div>
                <div id="solidgauge4" class="col-md-6 col-xs-4" style="height: 250px; float: left"><?php 
                $charttitle4 = "ร้อยละการคัดกรองความดันโลหิตสูง ในประชากรไทย อายุ 35 ปีขึ้นไป";?>
                </div>
            </div>
            <?php            
            $sql3 = Yii::$app->db->createCommand(
                    "SELECT 
                        ROUND((sum(result))/(sum(target))*100,2) as total 
                        FROM s_kpi_ckd_screen 
                        LEFT JOIN ( 
                            SELECT	ampurcodefull as ar_code,ampurname as ar_name,ampurcodefull as l_code 
                            FROM campur 
                            GROUP BY l_code	
                            ORDER BY l_code 
                        ) as ar ON left(s_kpi_ckd_screen.areacode,4)=ar.l_code
                        WHERE id = '0f6df79c2f8887f50d7879b5fe91c080' AND b_year = '2559' AND left(areacode,2)='42' 
                        GROUP BY ar_code "
                    )->queryScalar();
            $sql4 = Yii::$app->db->createCommand(
                    "SELECT 
                        ROUND(((SUM(result_group3)+SUM(result_group4))
                        /(SUM(pop_group3)+SUM(pop_group4)))*100,2) AS total
                    FROM s_ht_screen_pop_age 
                        LEFT JOIN ( 
                                    SELECT 
                                    ampurcodefull as ar_code,ampurname as ar_name,ampurcodefull as l_code 
                                    FROM campur 
                                    GROUP BY l_code	
                                    ORDER BY l_code 
                        ) as ar ON left(s_ht_screen_pop_age.areacode,4)=ar.l_code
                        WHERE id = '68e401815a64e624c286d97ef3582aa3' AND b_year = '2559' AND left(areacode,2)='42' 
                        GROUP BY ar_code "
                    )->queryScalar();
            $this->registerJs(" $(function () {
                    var gaugeOptions = {

                    chart: {
                        type: 'solidgauge',
                        borderWidth: 0,
                        borderRadius: 10,
                    },

                    title: {
                        text : ''
                    },

                    pane: {
                        center: ['50%', '75%'],
                        size: '85%', //ขนาดของ Gauge
                        startAngle: -90,
                        endAngle: 90,
                        background: {
                            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#DDD',
                            innerRadius: '60%',
                            outerRadius: '100%',
                            shape: 'arc'
                        }
                    },

                    tooltip: {
                        enabled: false
                    },

                    // the value axis
                    yAxis: {
                        stops: [
                            [90, '#55BF3B'], // green
                            //[0, '#DDDF0D'] // yellow
                            [0, '#DF5353'] // red
                        ],
                        lineWidth: 0,
                        minorTickInterval: null,
                        tickPixelInterval: 400,
                        tickWidth: 0,

                        title: {
                            y: -70
                        },
                        labels: {
                            y: 16
                        }
                    },

                    plotOptions: {
                        solidgauge: {
                            dataLabels: {
                                y: 5,
                                borderWidth: 0,
                                useHTML: true
                            }
                        }
                    }
                };

                // solidgauge3
                $('#solidgauge3').highcharts(Highcharts.merge(gaugeOptions, {
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: '$charttitle3'
                        }
                    },

                    credits: {
                        enabled: false
                    },

                    series: [{
                        name: ' ',
                        data: [$sql3],
                        dataLabels: {
                            format: ['$sql3 %'],
                        },
                        tooltip: {
                            valueSuffix: ' %'
                        }
                    }]

                }));
                //End solidgauge 3//
                
                // solidgauge4
                $('#solidgauge4').highcharts(Highcharts.merge(gaugeOptions, {
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: '$charttitle4'
                        }
                    },
                    
                    credits: {
                        enabled: false
                    },

                    series: [{
                        name: '',
                        data: [['ร้อยละ',$sql4]],
                        dataLabels: {
                            format: ['$sql4 %']
                        },
                        tooltip: {
                            valueSuffix: ' %'
                        }
                    }]
                }));
                
            });
        ");?>
        </div>
    </div>
    <!-- end solid gauge screen ckd -->

</div>

<?php
$this->registerJsFile('./js/chart_dial.js');
$dir_web = Yii::$app->request->BaseUrl;
$this->registerJsFile($dir_web . '/js/chart-donut.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<!--<div class="row"></div>
<div>
    <a class="btn btn-small btn-danger" href="<?= yii\helpers\Url::to(['site/login']) ?>">
        เข้าสู่ระบบ
    </a>
</div>-->

</div>
