<?php

namespace frontend\controllers;

use Yii;                            // ประกาศทุกครั้งที่สร้างไฟล์ Controller
use yii\web\Controller;             // ประกาศทุกครั้งที่สร้างไฟล์ Controller


class ReportController extends Controller
{
    //put your code here
    
    //function ตารางแสดงข้อมูลตัวชี้วัด DM
    public function actionDmctrl()
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
    
    //func ตาราง แสดงข้อมูล แยกราย รพ.
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
    //End func ตาราง แสดงข้อมูล แยกราย รพ.
    
    //func ตาราง แสดงข้อมูล แยกรายบุคคล
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
    //End func ตาราง แสดงข้อมูล แยกรายบุคคล
    
    
    //ht control amp
    public function actionHtctrl() {


        $sql = "SELECT  ar_code AS areacode,
                        ar_name AS areaname,
                        sum(target) AS target,
                        sum(result) AS result,
                        ROUND((sum(result) / sum(target)) * 100,2) AS p
                FROM s_ht_control
                LEFT JOIN (
                        SELECT
                                ampurcodefull AS ar_code,
                                ampurname AS ar_name,
                                ampurcodefull AS l_code
                        FROM campur
                        GROUP BY l_code
                        ORDER BY l_code
                ) AS ar ON LEFT (s_ht_control.areacode, 4) = ar.l_code
                WHERE #id = '2e3813337b6b5377c2f68affe247d5f9'
                b_year = '2559'
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
        
        return $this->render('htctrlamp',[
            'dataProvider' => $dataProvider,
            'sql' => $sql,
        ]);
    }
    //end function ตารางแสดงข้อมูลตัวชี้วัด ht control
    
    //func ตาราง แสดงข้อมูล แยกราย รพ. ht control
    public function actionHtctrlhos($areacode)
    {
        
        $sql = "SELECT  ar_code AS areacodehos,
                        hosname,
                        hoscode,
                        sum(target) AS target,
                        sum(result) AS result,
                        ROUND((sum(result) / sum(target)) * 100,2) AS p
                FROM s_ht_control
                LEFT JOIN (
			SELECT
			CONCAT(provcode,distcode,subdistcode) AS ar_code,
			hoscode, hosname,
			CONCAT(provcode,distcode,subdistcode) AS l_code
			FROM chospital
			WHERE hostype IN('03','06','07')
			GROUP BY l_code
			ORDER BY l_code
                ) AS ar ON LEFT (s_ht_control.areacode, 6) = ar.l_code
                WHERE #id = '137a726340e4dfde7bbbc5d8aeee3ac3'
                b_year = '2559'
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
        
        return $this->render('htctrlhos',[
            'dataProvider' => $dataProvider,
            'areacode' => $areacode,
            'sql' =>  $sql,
        ]);
    }
    //End func ตาราง แสดงข้อมูล ht ctrl แยกราย รพ.
    
    //func ตาราง แสดงข้อมูล ht ctrl แยกรายบุคคล
    public function actionHtctrlpid($hoscode,$areacodehos)
    {
        $date1 = date('Y-m-d'); //"2014-10-01";
        $date2 = date('Y-m-d');
        
        if (Yii::$app->request->isPost) {
            $date1 = date('Y-m-d', strtotime($_POST['date1']));
            $date2 = date('Y-m-d', strtotime($_POST['date2']));
    }
        $sql = "SELECT 'Target',
                    d.hospcode, d.pid, d.age_y, d.typearea, d.groupname1560,
                    d.mix_dx, d.type_dx, d.t_mix_dx, d.date_dx, d.hosp_dx,
                    d.rs_bps1, d.rs_bpd1, d.ld_bp1,
                    d.rs_bps2, d.rs_bpd2, d.ld_bp2,
                    d.weight, d.height, d.waist_cm,
                    d.bmi, d.vhid, d.control_ht
                    FROM t_dmht d
                    WHERE type_dx in(1,3)
                    AND LEFT(d.vhid,6)='$areacodehos'
                    AND d.hospcode='$hoscode'

                    UNION ALL

                    -- --------------------------------------- Result
                    SELECT 'Result',
                    d.hospcode, d.pid, d.age_y, d.typearea, d.groupname1560,
                    d.mix_dx, d.type_dx, d.t_mix_dx, d.date_dx, d.hosp_dx,
                    d.rs_bps1, d.rs_bpd1, d.ld_bp1,
                    d.rs_bps2, d.rs_bpd2, d.ld_bp2,
                    d.weight, d.height, d.waist_cm,
                    d.bmi, d.vhid, d.control_ht
                    FROM t_dmht d
                    WHERE type_dx in(1) AND rs_bps1 <140 AND rs_bps2 <140 AND rs_bpd1 <90 AND rs_bpd2 <90 
                    AND ld_bp1 BETWEEN '$date1' AND '$date2'
                    AND LEFT(d.vhid,6)='$areacodehos'
                    AND d.hospcode='$hoscode'

                    UNION ALL

                    SELECT 'Result',
                    d.hospcode, d.pid, d.age_y, d.typearea, d.groupname1560,
                    d.mix_dx, d.type_dx, d.t_mix_dx, d.date_dx, d.hosp_dx,
                    d.rs_bps1, d.rs_bpd1, d.ld_bp1,
                    d.rs_bps2, d.rs_bpd2, d.ld_bp2,
                    d.weight, d.height, d.waist_cm,
                    d.bmi, d.vhid, d.control_ht 
                    FROM t_dmht d
                    WHERE type_dx in(3) AND rs_bps1 <140 AND rs_bps2 <140 AND rs_bpd1 <80 AND rs_bpd2 <80 
                    AND ld_bp1 BETWEEN '$date1' AND '$date2'
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
        
        return $this->render('htctrlpid',[
            'dataProvider' => $dataProvider,
            'hoscode' => $hoscode,
            'sql' =>  $sql,
            'date1' => $date1,
            'date2' => $date2
            
        ]);
    }
    //End func ตาราง แสดงข้อมูล แยกรายบุคคล
    
    //ht Screen 35year up Amp
    public function actionHtscramp() {
        
        $sql = "SELECT 
                ar_code as areacode,ar_name as areaname 
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
        
        return $this->render('htscramp',[
            'dataProvider' => $dataProvider,
            'sql' => $sql,
        ]);
    }
    //end function ตารางแสดงข้อมูลตัวชี้วัด ht Screen
    
    //func ตาราง แสดงข้อมูล แยกราย รพ. ht screen
    public function actionHtscrhos($areacode)
    {
        
        $sql = "SELECT ar_code AS areacodehos,hosname,hoscode
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
        
        return $this->render('htscrhos',[
            'dataProvider' => $dataProvider,
            'areacode' => $areacode,
            'sql' =>  $sql,
        ]);
    }
    //End func ตาราง แสดงข้อมูล ht screen แยกราย รพ.
    
    //func ตาราง แสดงข้อมูล ht Screen แยกรายบุคคล
    public function actionHtscrpid($hoscode,$areacodehos)
    {
        $date1 = date('Y-m-d'); //"2014-10-01";
        $date2 = date('Y-m-d');
        
        if (Yii::$app->request->isPost) {
            $date1 = date('Y-m-d', strtotime($_POST['date1']));
            $date2 = date('Y-m-d', strtotime($_POST['date2']));
    }
        $sql = "SELECT t.hospcode, t.cid, t.pid, t.age_y, t.typearea, t.date_screen,
                t.sbp, t.dbp, t.sbp_1, t.dbp_1, t.sbp_2, t.dbp_2, t.risk, t.areacode
                FROM t_person_ht_screen t
                WHERE t.hospcode='$hoscode' 
                AND LEFT(t.areacode,6)='$areacodehos'
                ORDER BY t.date_screen DESC ";
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
        
        return $this->render('htscrpid',[
            'dataProvider' => $dataProvider,
            'hoscode' => $hoscode,
            'sql' =>  $sql,
            'date1' => $date1,
            'date2' => $date2
            
        ]);
    }
    //End func ตาราง แสดงข้อมูล แยกรายบุคคล
    
    //DMHT Screen Kidney Amp
    public function actionChscrkidneyamp() {
        $budget= NULL;
        if (Yii::$app->request->isPost) {
            $budget = $_POST['budget'];
        }
        
         if ($budget == NULL) {
            $sql = "SELECT 
                ar_code as areacode
                ,ar_name as areaname 
                ,SUM(target) as target 
                ,SUM(result) as result
                ,FORMAT(((SUM(result))/(SUM(target)))*100,2)AS p
                ,SUM(result1) as resultq1
                ,FORMAT(((SUM(result1))/(SUM(target)))*100,2)AS pq1
                ,SUM(result2) as resultq2
                ,FORMAT(((SUM(result2))/(SUM(target)))*100,2)AS pq2
                ,SUM(result3) as resultq3
                ,FORMAT(((SUM(result3))/(SUM(target)))*100,2)AS pq3
                ,SUM(result4) as resultq4 
                ,FORMAT(((SUM(result4))/(SUM(target)))*100,2)AS pq4
                FROM s_kpi_ckd_screen 
                LEFT JOIN ( 
                SELECT	
                ampurcodefull as ar_code, 
                ampurname as ar_name, 
                ampurcodefull as l_code 
                FROM campur 
                GROUP BY l_code	
                ORDER BY l_code 
                ) as ar ON left(s_kpi_ckd_screen.areacode,4)=ar.l_code
                WHERE id = '0f6df79c2f8887f50d7879b5fe91c080' 
                AND b_year = '2559' 
                AND left(areacode,2)='42' 
                GROUP BY ar_code";
		}else{
			        
        $sql = "SELECT 
                ar_code as areacode
                ,ar_name as areaname 
                ,SUM(target) as target 
                ,SUM(result) as result
                ,FORMAT(((SUM(result))/(SUM(target)))*100,2)AS p
                ,SUM(result1) as resultq1
                ,FORMAT(((SUM(result1))/(SUM(target)))*100,2)AS pq1
                ,SUM(result2) as resultq2
                ,FORMAT(((SUM(result2))/(SUM(target)))*100,2)AS pq2
                ,SUM(result3) as resultq3
                ,FORMAT(((SUM(result3))/(SUM(target)))*100,2)AS pq3
                ,SUM(result4) as resultq4 
                ,FORMAT(((SUM(result4))/(SUM(target)))*100,2)AS pq4
                FROM s_kpi_ckd_screen 
                LEFT JOIN ( 
                SELECT	
                ampurcodefull as ar_code, 
                ampurname as ar_name, 
                ampurcodefull as l_code 
                FROM campur 
                GROUP BY l_code	
                ORDER BY l_code 
                ) as ar ON left(s_kpi_ckd_screen.areacode,4)=ar.l_code

                WHERE id = '0f6df79c2f8887f50d7879b5fe91c080' 
                AND b_year = '$budget' 
                AND left(areacode,2)='42' 
                GROUP BY ar_code";
                }
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
        
        return $this->render('chscrkidneyamp',[
            'dataProvider' => $dataProvider,
            'sql' => $sql,
        ]);
    }
    //end function ตารางแสดงข้อมูลตัวชี้วัด DMHT Screen Kidney
    
    //func ตาราง แสดงข้อมูล แยกราย รพ. DMHT Screen Kidney
    public function actionChscrkidneyhos($areacode)
    {
        
        $sql = "SELECT ar_code AS areacodehos,
                        hosname, hoscode
                        ,SUM(target) as target 
                        ,SUM(result) as result
                        ,FORMAT(((SUM(result))/(SUM(target)))*100,2)AS p
                        ,SUM(result1) as resultq1
                        ,FORMAT(((SUM(result1))/(SUM(target)))*100,2)AS pq1
                        ,SUM(result2) as resultq2
                        ,FORMAT(((SUM(result2))/(SUM(target)))*100,2)AS pq2
                        ,SUM(result3) as resultq3
                        ,FORMAT(((SUM(result3))/(SUM(target)))*100,2)AS pq3
                        ,SUM(result4) as resultq4 
                        ,FORMAT(((SUM(result4))/(SUM(target)))*100,2)AS pq4
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
        
        return $this->render('chscrkidneyhos',[
            'dataProvider' => $dataProvider,
            'areacode' => $areacode,
            'sql' =>  $sql,
        ]);
    }
    //End func ตาราง แสดงข้อมูล DMHT Screen Kidney แยกราย รพ.
    
}
