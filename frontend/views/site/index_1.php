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
<div class="site-index" style="margin-top: 100px">
    <div class="col-sm-4">
        
        <!-- donut chart 1 -->
        <div class="panel-body">
            <div style="display: none">
                <?php
                echo Highcharts::widget([
                    'scripts' => [
                        'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'modules/exporting', // adds Exporting button/menu to chart
                    //'themes/grid', // applies global 'grid' theme to all charts
                    //'highcharts-3d'
                    //'modules/drilldown'
                    ]
                ]);
                ?>
            </div>
        <div id="pie-donut"></div>
            <?php
            $title = "ร้อยละ";
            $sql = Yii::$app->db->createCommand(
                    "SELECT
                    ROUND((SUM(a.result))/(SUM(a.target))*100)AS total
                    FROM s_breast_screen a
                    WHERE a.b_year BETWEEN 2558 AND 2559"
                    )->queryScalar();
            $this->registerJs("$(function () {
                                    $('#pie-donut').highcharts({
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: 'pie'
                                        },
                                        title: {
                                            text: '$title'
                                        },
                                        tooltip: {
                                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                        },
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                depth: 35,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',    //  แสดง %
                                                    style: {
                                                        color:'black'                     
                                                    },
                                                    connectorColor: 'silver'
                                                },
                                                startAngle: -90,
                                                endAngle: 90,
                                                center: ['50%', '75%']
                                            }
                                        },
                                        /*plotOptions: {
                                            pie: {
                                                dataLabels: {
                                                    allowPointSelect: true,
                                                    cursor: 'pointer',
                                                    depth: 35,
                                                    style: {
                                                        color:'black',                 
                                                    },
                                                    connectorColor: 'silver'
                                                },
                                                startAngle: -90,
                                                endAngle: 90,
                                                center: ['50%', '75%']
                                            }
                                        },*/
                                        legend: {
                                            enabled: true
                                        },
                                        series: [{
                                            type: 'pie',
                                            name: 'ร้อยละ',
                                            innerSize: '50%',
                                            data: [
                                                ['ร้อยละ', $sql],
                                            ]
                                        }]
                                    });
                                });
                                ");
            ?>
        </div>
    </div>
    <!-- end donut chart 1 -->
    
    <div class="col-sm-4">
        <!-- donut chart 2 -->
        <div class="panel-body">
            <div style="display: none">
                <?php
                echo Highcharts::widget([
                    'scripts' => [
                        'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'modules/exporting', // adds Exporting button/menu to chart
                    //'themes/grid', // applies global 'grid' theme to all charts
                    //'highcharts-3d'
                    //'modules/drilldown'
                    ]
                ]);
                ?>
            </div>
        <div id="pie-donut2"></div>
            <?php
            $title = "ร้อยละ";
            $sql2 = Yii::$app->db->createCommand(
                    "SELECT FORMAT((SUM(stage1)/SUM(target)),2)AS cc
                     FROM s_ckd_ncd s
                     WHERE s.date_com BETWEEN '2014-10-01' AND '2015-09-30'"
                    )->queryScalar();
            $this->registerJs("$(function () {
                                    $('#pie-donut2').highcharts({
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: 'pie'
                                        },
                                        title: {
                                            text: '$title'
                                        },
                                        tooltip: {
                                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                        },
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                depth: 35,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',    //  แสดง %
                                                    style: {
                                                        color:'black'                     
                                                    },
                                                    connectorColor: 'silver'
                                                },
                                                startAngle: -90,
                                                endAngle: 90,
                                                center: ['50%', '75%']
                                            }
                                        },
                                        /*plotOptions: {
                                            pie: {
                                                dataLabels: {
                                                    allowPointSelect: true,
                                                    cursor: 'pointer',
                                                    depth: 35,
                                                    style: {
                                                        color:'black',                 
                                                    },
                                                    connectorColor: 'silver'
                                                },
                                                startAngle: -90,
                                                endAngle: 90,
                                                center: ['50%', '75%']
                                            }
                                        },*/
                                        legend: {
                                            enabled: true
                                        },
                                        series: [{
                                            type: 'pie',
                                            name: 'ร้อยละ',
                                            innerSize: '50%',
                                            data: [
                                                ['ร้อยละ', $sql2],
                                            ]
                                        }]
                                    });
                                });
                                ");
            ?>
        </div>
    </div>
    <!--end donut chart 2 -->
    
    <div class="col-sm-4">
        <!-- donut chart 3-->
        <div class="panel-body">
            <div style="display: none">
                <?php
                echo Highcharts::widget([
                    'scripts' => [
                        'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'modules/exporting', // adds Exporting button/menu to chart
                    //'themes/grid', // applies global 'grid' theme to all charts
                    //'highcharts-3d'
                    //'modules/drilldown'
                    ]
                ]);
                ?>
            </div>
        <div id="pie-donut3"></div>
            <?php
            $title = "ร้อยละ";
            $sql3 = Yii::$app->db->createCommand(
                    "SELECT FORMAT((SUM(stage1)/SUM(target)),2)AS cc
                     FROM s_ckd_ncd s
                     WHERE s.date_com BETWEEN '2014-10-01' AND '2015-09-30'"
                    )->queryScalar();
            $this->registerJs("$(function () {
                                    $('#pie-donut3').highcharts({
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: 'pie'
                                        },
                                        title: {
                                            text: '$title'
                                        },
                                        tooltip: {
                                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                        },
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                depth: 35,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',    //  แสดง %
                                                    style: {
                                                        color:'black'                     
                                                    },
                                                    connectorColor: 'silver'
                                                },
                                                startAngle: -90,
                                                endAngle: 90,
                                                center: ['50%', '75%']
                                            }
                                        },
                                        /*plotOptions: {
                                            pie: {
                                                dataLabels: {
                                                    allowPointSelect: true,
                                                    cursor: 'pointer',
                                                    depth: 35,
                                                    style: {
                                                        color:'black',                 
                                                    },
                                                    connectorColor: 'silver'
                                                },
                                                startAngle: -90,
                                                endAngle: 90,
                                                center: ['50%', '75%']
                                            }
                                        },*/
                                        legend: {
                                            enabled: true
                                        },
                                        series: [{
                                            type: 'pie',
                                            name: 'ร้อยละ',
                                            innerSize: '50%',
                                            data: [
                                                ['ร้อยละ', $sql3],
                                            ]
                                        }]
                                    });
                                });
                                ");
            ?>
        </div>
    </div>
    <!--end donut chart 3 -->
    
    
    <div class="col-sm-4">
        <!-- donut chart 4-->
        <div class="panel-body">
            <div style="display: none">
                <?php
                echo Highcharts::widget([
                    'scripts' => [
                        'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'modules/exporting', // adds Exporting button/menu to chart
                    //'themes/grid', // applies global 'grid' theme to all charts
                    //'highcharts-3d'
                    //'modules/drilldown'
                    ]
                ]);
                ?>
            </div>
        <div id="pie-donut4"></div>
            <?php
            $title = "ร้อยละ";
            $sql3 = Yii::$app->db->createCommand(
                    "SELECT FORMAT((SUM(stage1)/SUM(target)),2)AS cc
                     FROM s_ckd_ncd s
                     WHERE s.date_com BETWEEN '2014-10-01' AND '2015-09-30'"
                    )->queryScalar();
            $this->registerJs("$(function () {
                                    $('#pie-donut4').highcharts({
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: 'pie'
                                        },
                                        title: {
                                            text: '$title'
                                        },
                                        tooltip: {
                                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                        },
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                depth: 35,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',    //  แสดง %
                                                    style: {
                                                        color:'black'                     
                                                    },
                                                    connectorColor: 'silver'
                                                },
                                                startAngle: -90,
                                                endAngle: 90,
                                                center: ['50%', '75%']
                                            }
                                        },
                                        /*plotOptions: {
                                            pie: {
                                                dataLabels: {
                                                    allowPointSelect: true,
                                                    cursor: 'pointer',
                                                    depth: 35,
                                                    style: {
                                                        color:'black',                 
                                                    },
                                                    connectorColor: 'silver'
                                                },
                                                startAngle: -90,
                                                endAngle: 90,
                                                center: ['50%', '75%']
                                            }
                                        },*/
                                        legend: {
                                            enabled: true
                                        },
                                        series: [{
                                            type: 'pie',
                                            name: 'ร้อยละ',
                                            innerSize: '50%',
                                            data: [
                                                ['ร้อยละ', $sql3],
                                            ]
                                        }]
                                    });
                                });
                                ");
            ?>
        </div>
    </div>
        <!--end donut chart 4-->
        
        <div class="col-sm-4">
        <!-- donut chart 5-->
        <div class="panel-body">
            <div style="display: none">
                <?php
                echo Highcharts::widget([
                    'scripts' => [
                        'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'modules/exporting', // adds Exporting button/menu to chart
                    //'themes/grid', // applies global 'grid' theme to all charts
                    //'highcharts-3d'
                    //'modules/drilldown'
                    ]
                ]);
                ?>
            </div>
        <div id="pie-donut5"></div>
            <?php
            $title = "ร้อยละ";
            $sql3 = Yii::$app->db->createCommand(
                    "SELECT FORMAT((SUM(stage1)/SUM(target)),2)AS cc
                     FROM s_ckd_ncd s
                     WHERE s.date_com BETWEEN '2014-10-01' AND '2015-09-30'"
                    )->queryScalar();
            $this->registerJs("$(function () {
                                    $('#pie-donut5').highcharts({
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: 'pie'
                                        },
                                        title: {
                                            text: '$title'
                                        },
                                        tooltip: {
                                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                        },
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                depth: 35,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',    //  แสดง %
                                                    style: {
                                                        color:'black'                     
                                                    },
                                                    connectorColor: 'silver'
                                                },
                                                startAngle: -90,
                                                endAngle: 90,
                                                center: ['50%', '75%']
                                            }
                                        },
                                        /*plotOptions: {
                                            pie: {
                                                dataLabels: {
                                                    allowPointSelect: true,
                                                    cursor: 'pointer',
                                                    depth: 35,
                                                    style: {
                                                        color:'black',                 
                                                    },
                                                    connectorColor: 'silver'
                                                },
                                                startAngle: -90,
                                                endAngle: 90,
                                                center: ['50%', '75%']
                                            }
                                        },*/
                                        legend: {
                                            enabled: true
                                        },
                                        series: [{
                                            type: 'pie',
                                            name: 'ร้อยละ',
                                            innerSize: '50%',
                                            data: [
                                                ['ร้อยละ', $sql3],
                                            ]
                                        }]
                                    });
                                });
                                ");
            ?>
        </div>
        <!--end donut chart 5-->
        </div>
        
        <div class="col-sm-4">
        <!-- donut chart 6-->
        <div class="panel-body">
            <div style="display: none">
                <?php
                echo Highcharts::widget([
                    'scripts' => [
                        'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'modules/exporting', // adds Exporting button/menu to chart
                    //'themes/grid', // applies global 'grid' theme to all charts
                    //'highcharts-3d'
                    //'modules/drilldown'
                    ]
                ]);
                ?>
            </div>
        <div id="pie-donut6"></div>
            <?php
            $title = "ร้อยละ";
            $sql3 = Yii::$app->db->createCommand(
                    "SELECT FORMAT((SUM(stage1)/SUM(target)),2)AS cc
                     FROM s_ckd_ncd s
                     WHERE s.date_com BETWEEN '2014-10-01' AND '2015-09-30'"
                    )->queryScalar();
            $this->registerJs("$(function () {
                                    $('#pie-donut6').highcharts({
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: 'pie'
                                        },
                                        title: {
                                            text: '$title'
                                        },
                                        tooltip: {
                                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                        },
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                depth: 35,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',    //  แสดง %
                                                    style: {
                                                        color:'black'                     
                                                    },
                                                    connectorColor: 'silver'
                                                },
                                                startAngle: -90,
                                                endAngle: 90,
                                                center: ['50%', '75%']
                                            }
                                        },
                                        /*plotOptions: {
                                            pie: {
                                                dataLabels: {
                                                    allowPointSelect: true,
                                                    cursor: 'pointer',
                                                    depth: 35,
                                                    style: {
                                                        color:'black',                 
                                                    },
                                                    connectorColor: 'silver'
                                                },
                                                startAngle: -90,
                                                endAngle: 90,
                                                center: ['50%', '75%']
                                            }
                                        },*/
                                        legend: {
                                            enabled: true
                                        },
                                        series: [{
                                            type: 'pie',
                                            name: 'ร้อยละ',
                                            innerSize: '50%',
                                            data: [
                                                ['ร้อยละ', $sql3],
                                            ]
                                        }]
                                    });
                                });
                                ");
            ?>
        </div>
        <!--end donut chart 6-->
        </div>

        
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
