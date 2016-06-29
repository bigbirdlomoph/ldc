<?php

namespace frontend\controllers;

use Yii;                            // ประกาศทุกครั้งที่สร้างไฟล์ Controller
use yii\web\Controller;             // ประกาศทุกครั้งที่สร้างไฟล์ Controller


class ReportController extends Controller
{
    //put your code here
    
    //function ตารางแสดงข้อมูลตัวชี้วัด DM
    public function actionReport()
    {
        $sql = "SELECT
                        ar_code AS areacode,
                        ar_name AS areaname,
                        sum(target) AS target,
                        sum(result) AS result,
                        ROUND((sum(result) / sum(target)) * 100,2) AS p
                FROM s_dm_control
                LEFT JOIN (
                        SELECT
                                ampurcodefull AS ar_code,
                                ampurname AS ar_name,
                                ampurcodefull AS l_code
                        FROM
                                campur
                        GROUP BY
                                l_code
                        ORDER BY
                                l_code
                ) AS ar ON LEFT (s_dm_control.areacode, 4) = ar.l_code
                WHERE
                        id = '137a726340e4dfde7bbbc5d8aeee3ac3'
                AND b_year = '2559'
                AND LEFT (areacode, 2) = '42'
                GROUP BY ar_code";
        $areacode = Yii::$app->request->post('areacode');  
        $areaname = Yii::$app->request->post('areaname');  
        
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => FALSE,
                'pagination' => [
                    'pageSize' => 15,
                ],
        ]);
        
        return $this->render('dmcontrol',[
            'dataProvider' => $dataProvider,
            'sql' => $sql,
        ]);
    }
    //end function ตารางแสดงข้อมูลตัวชี้วัด DM
    
    
    public function actionDmctrlhos($areacode)
    {
        
        $sql = "SELECT  ar_code AS areacodehos,
                        hosname,
                        hoscode,
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
            $areacodehos = Yii::$app->request->post('areacodehos');
            $hosname = Yii::$app->request->post('hosname');  
            $hoscode = Yii::$app->request->post('hoscode');
        
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => FALSE,
                'pagination' => [
                    'pageSize' => 15,
                ],
        ]);
        
        return $this->render('dmctrlhos',[
            'dataProvider' => $dataProvider,
            'areacode' => $areacode,
            'sql' =>  $sql,
        ]);
    }
    
    
    public function actionDmctrlpid($hoscode,$areacodehos)
    {
        
        $sql = "SELECT  'Target',
                        d.hospcode, d.pid, d.age_y, d.typearea, d.groupname1560,
                        d.mix_dx, d.type_dx, d.t_mix_dx, d.date_dx, d.hosp_dx,
                        d.rs_hba1c, d.ld_hba1c, d.ih_hba1c,
                        d.rs_fpg1, d.ld_fpg1, d.ih_fpg1,
                        d.rs_fpg2, d.ld_fpg2, d.ih_fpg2,
                        d.rs_fpg3, d.ld_fpg3, d.ih_fpg3,
                        d.vhid, d.control_dm
                FROM t_dmht d
                WHERE type_dx in('02','03')
                    AND LEFT(d.vhid,6)='$areacodehos'
                    AND d.hospcode='$hoscode'";
            $hoscode = Yii::$app->request->post('hoscode');
            $areacodehos = Yii::$app->request->post('areacodehos');
        
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => FALSE,
                'pagination' => [
                    'pageSize' => 20,
                ],
        ]);
        
        return $this->render('dmctrlpid',[
            'dataProvider' => $dataProvider,
            'hoscode' => $hoscode,
            'sql' =>  $sql,
        ]);
    }
}
