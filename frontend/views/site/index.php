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

$this->title = 'Loei Data';
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
            <div style="width: 800px; height: 600px; margin: 0 auto">
            <div id="solidgauge1" style="width: 400px; height: 300px; float: left"></div>
            <div id="solidgauge2" style="width: 400px; height: 300px; float: left"></div>
            </div>
            <?php
            $charttitle = "ร้อยละผู้ป่วยโรคเบาหวานที่ควบคุมระดับน้ำตาลได้ดี";
            $charttitle2 = "ร้อยละผู้ป่วยโรคความดันโลหิตสูงที่ควบคุมความดันโลหิตได้ดี";
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
                
                // The RPM gauge
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
        ");
            ?>
        </div>
    </div>
    <!-- end solid gauge 1 -->

</div>

<?php
$this->registerJsFile('./js/chart_dial.js');
$dir_web = Yii::$app->request->BaseUrl;
$this->registerJsFile($dir_web . '/js/chart-donut.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="row"></div>
<div>
    <a class="btn btn-small btn-danger" href="<?= yii\helpers\Url::to(['site/login']) ?>">
        เข้าสู่ระบบ
    </a>
</div>

</div>
