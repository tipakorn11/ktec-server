<?php
class UserModel
{
    public function generateUserLastCode($data){
        try {
            $db = new db();
            $db = $db->connect();
            $sql = "SELECT CONCAT('".$data['code']."', LPAD(IFNULL(MAX(CAST(SUBSTRING(personalID,'".(strlen($data['code'])+1)."','".$data['digit']."') AS SIGNED)),0) + 1,'".$data['digit']."',0)) AS last_code FROM tb_user WHERE personalID LIKE '".$data['code']."%'";
            $query = $db->query($sql);
            $result = $query->fetchObject();
            $db = null;
            
            if (!$result) {
                return ['data'=>[],'require'=>false];
            } else {
                return ['data' => $result,'require'=>true];
            }
        } catch (PDOException $e) {
            return ['data'=>[],'require'=>false];
            $db = null;
        }
    }
    //แสดงผู้ใช้
    public function getUserBy($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            // query
            $sql = "SELECT *,
            IFNULL((SELECT course_name from course where course.courseID = tb_user.courseID),NULL) as course_name ,
            IFNULL((SELECT prefix_name from prefix where prefix.prefixID = tb_user.prefixID),NULL) as prefix_name 
            FROM tb_user WHERE TRUE";
            
            $query = $db->query($sql);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            $count = count($result);
            $db = null;
            if (!$result) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => $result, 'require' => true,'total'=>$count];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data' => [], 'require' => false];
        }
    }
    public function getUserCitizenid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            // query
            $sql = $db -> prepare("SELECT citizenID
                    FROM tb_user 
                    WHERE citizenID = :citizenID");
            $sql->bindParam(':citizenID',$data['citizenID']);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            $count = count($result);
            $db = null;
            if (!$result) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => $result, 'require' => true,'total'=>$count];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data' => [], 'require' => false];
        }
    }
    public function getUserByUsername($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db -> prepare("SELECT username
                    FROM tb_user 
                    WHERE username = :username");
            $sql->bindParam(':username',$data['username']);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            $count = count($result);
            $db = null;
            if (!$result) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => $result, 'require' => true,'total'=>$count];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data' => [], 'require' => false];
        }
    }
    public function auth($data)
    {
        try {
            $jwt = new JwtHandler();
            $decode = $jwt->isAuth($data);
            
            return $decode;
        } catch (\Exception $e) {
            // show error message as Json format
            echo '{"error": {"msg": ' . $e->getMessage() . '}';
        }
    }

    public function getUserByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db -> prepare("SELECT *,
                                    IFNULL((SELECT prefix_name FROM prefix WHERE prefix.prefixID = tb_user.prefixID),tb_user.prefixID) AS prefix_name,
                                    IFNULL((SELECT course_name FROM course WHERE course.courseID = tb_user.courseID),tb_user.courseID) AS course_name



                                    FROM tb_user  
                                    WHERE tb_user.personalID = :usid ");
            
            $sql->bindParam(':usid',$data['personalID']);
            $sql->execute();
            $tb_user = $sql->fetchAll(PDO::FETCH_OBJ);

            $sql = $db -> prepare("SELECT * FROM education WHERE personalID = :pid ");
            $sql->bindParam(':pid',$data['personalID']);
            $sql->execute();
            $education = $sql->fetchAll(PDO::FETCH_OBJ);
         
            $sql = $db -> prepare("SELECT *,DATEDIFF( training_end_date,training_date) AS date_diff FROM training_certificate WHERE personalID = :usid ");
            $sql->bindParam(':usid',$data['personalID']);
            $sql->execute();
            $training = $sql->fetchAll(PDO::FETCH_OBJ);
            
            $sql = $db -> prepare("SELECT *,ifnull((SELECT position.position_name FROM position WHERE user_position.positionID = position.positionID ),positioniD ) as position_name FROM user_position WHERE personalID = :usid");
            $sql->bindParam(':usid',$data['personalID']);
            $sql->execute();
            $position = $sql->fetchAll(PDO::FETCH_OBJ);

            $sql = $db -> prepare("SELECT * FROM useraddress WHERE personalID = :usid ");
            $sql->bindParam(':usid',$data['personalID']);
            $sql->execute();
            $useraddress = $sql->fetchAll(PDO::FETCH_OBJ);
            try{
                $sql = $db -> prepare("SELECT * FROM teacher_license WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $tl = $sql->fetchAll(PDO::FETCH_OBJ);

                $sql = $db -> prepare("SELECT * FROM teacher_permission_license WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $tpl = $sql->fetchAll(PDO::FETCH_OBJ);

                $sql = $db -> prepare("SELECT * FROM ht_license WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $ht_license = $sql->fetchAll(PDO::FETCH_OBJ);
            
            

            }
            catch(throwable $e){}

            try { 
                $sql = $db -> prepare("SELECT * FROM appointment WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $appointment = $sql->fetchAll(PDO::FETCH_OBJ);
                
          
            } catch (throwable $e) {}

            try {
                $sql = $db -> prepare("SELECT * FROM portfolio WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $portfolio = $sql->fetchAll(PDO::FETCH_OBJ);
    
              
            
            } catch (Throwable $e) {}
            
            try {
                $sql = $db -> prepare("SELECT * FROM insignia WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $insignia = $sql->fetchAll(PDO::FETCH_OBJ);
    
            } catch (Throwable $e) {}
           
            try {
                $sql = $db -> prepare("SELECT * FROM punishment WHERE personalID = :usid ");
                $sql->bindParam(':usid',$data['personalID']);
                $sql->execute();
                $punishment = $sql->fetchAll(PDO::FETCH_OBJ);
                   
            } catch (Throwable $e) {}
           
            $db = null;
            if (!$tb_user) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => $tb_user, 
                        'useraddress'=> $useraddress, 
                        'position' => $position,
                        'education' => $education,
                        'training' => $training,
                        'tl' => $tl,
                        'tpl' => $tpl,
                        'ht_license' => $ht_license,
                        'appointment' => $appointment,
                        'portfolio' => $portfolio,
                        'insignia' => $insignia,
                        'punishment' => $punishment,
                        'require' => true ,
                    ];
            }
        } catch (PDOException $e) {
            $db = null;
            return ['data' => 'catch', 'require' => false];
        }
    }
    public function updateUserByid($data)
    {
        try {

            //---------------USER------------------//
            //---------------USER------------------//
            //---------------USER------------------//
            //---------------USER------------------//
            //---------------USER------------------//

            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("UPDATE tb_user 
                                SET citizenID = :citizenid ,
                                    thai_fname = :thaifname,
                                    thai_lname = :thailname,
                                    eng_fname = :engfname,
                                    eng_lname = :englname,
                                    nationality = :nationality,
                                    bdate = :bdate,
                                    father_fname = :ffname,
                                    father_lname = :flname,
                                    mother_fname = :mfname,
                                    mother_lname = :mlname,
                                    courseID = :cid,
                                    prefixID = :pid
                                WHERE personalID = :personalid ; ");
            $sql->bindParam(':personalid', $data['personalID']);
            $sql->bindParam(':citizenid', $data['citizenID']);
            $sql->bindParam(':thaifname', $data['thai_fname']);
            $sql->bindParam(':thailname', $data['thai_lname']);
            $sql->bindParam(':engfname', $data['eng_fname']);
            $sql->bindParam(':englname', $data['eng_lname']);
            $sql->bindParam(':nationality', $data['nationality']);
            $sql->bindParam(':bdate', $data['bdate']);
            $sql->bindParam(':ffname', $data['father_fname']);
            $sql->bindParam(':flname', $data['father_lname']);
            $sql->bindParam(':mfname', $data['mother_fname']);
            $sql->bindParam(':mlname', $data['mother_lname']);
            $sql->bindParam(':cid', $data['courseID']);
            $sql->bindParam(':pid', $data['prefixID']);
            $sql->execute();

            //---------------ADDRESS------------------//
            //---------------ADDRESS------------------//
            //---------------ADDRESS------------------//
            //---------------ADDRESS------------------//
            //---------------ADDRESS------------------//

            $sql = $db->prepare("UPDATE useraddress 
                                SET addressID = :aid,
                                    personalID = :pid,
                                    village_no = :villageno,
                                    house_no = :houseno,
                                    alley = :alley,
                                    road = :road,
                                    sub_district = :subdistrict,
                                    sub_area = :subarea,
                                    country = :country,
                                    postal_code = :postalcode,
                                    tel = :tel
                                WHERE personalID = :pid ; ");
            $sql->bindParam(':aid', $data['addressID']);
            $sql->bindParam(':pid', $data['personalID']);
            $sql->bindParam(':villageno', $data['village_no']);
            $sql->bindParam(':houseno', $data['house_no']);
            $sql->bindParam(':alley', $data['alley']);
            $sql->bindParam(':road', $data['road']);
            $sql->bindParam(':subdistrict', $data['sub_district']);
            $sql->bindParam(':subarea', $data['sub_area']);
            $sql->bindParam(':country', $data['country']);
            $sql->bindParam(':postalcode', $data['postal_code']);
            $sql->bindParam(':tel', $data['tel']);
            $sql->execute();
            //---------------EDUCATIONS------------------//
            //---------------EDUCATIONS------------------//
            //---------------EDUCATIONS------------------//
            //---------------EDUCATIONS------------------//
            //---------------EDUCATIONS------------------//
            if(isset($data['educations'])){
                foreach($data['educations'] as $education){
                    $sql = $db->prepare("UPDATE education 
                                        SET educational_name = :educational_name,
                                            educational_major = :educational_major,
                                            institution_name = :institution_name,
                                            graduate_country = :graduate_country,
                                            graduate_date = :graduate_date
                                        WHERE personalID = :pid AND educational_typeID = :eid; ");
                                        $sql->bindParam(':eid',$education['educational_typeID']);
                                        $sql->bindParam(':pid',$education['personalID']);
                                        $sql->bindParam(':educational_name',$education['educational_name']);
                                        $sql->bindParam(':educational_major',$education['educational_major']);
                                        $sql->bindParam(':institution_name',$education['institution_name']);
                                        $sql->bindParam(':graduate_country',$education['graduate_country']);
                                        $sql->bindParam(':graduate_date',$education['graduate_date']);
                    $sql->execute();
                    }
                    
            }
            //---------------TRAINING------------------//
            //---------------TRAINING------------------//
            //---------------TRAINING------------------//
            //---------------TRAINING------------------//
            //---------------TRAINING------------------//

            if(isset($data['trainings'])){
                foreach($data['trainings'] as $training){
                    $sql = $db->prepare("UPDATE training_certificate 
                                        SET training_topic = :training_topic,
                                            training_agency = :training_agency,
                                            country_agency = :country_agency,
                                            training_date = :training_date,
                                            training_end_date = :training_end_date
                                        WHERE personalID = :pid AND trainningID = :tid; ");
                                        $sql->bindParam(':tid',$training['trainningID']);
                                        $sql->bindParam(':pid',$training['personalID']);
                                        $sql->bindParam(':training_topic',$training['training_topic']);
                                        $sql->bindParam(':country_agency',$training['country_agency']);
                                        $sql->bindParam(':training_agency',$training['training_agency']);
                                        $sql->bindParam(':training_date',$training['training_date']);
                                        $sql->bindParam(':training_end_date',$training['training_end_date']);
                    $sql->execute();
                }
            }
            //---------------TEACHER_LICENSE------------------//
            //---------------TEACHER_LICENSE------------------//
            //---------------TEACHER_LICENSE------------------//
            //---------------TEACHER_LICENSE------------------//
            //---------------TEACHER_LICENSE------------------//

            if(isset($data['teacher_licenses'])){
                foreach($data['teacher_licenses'] as $teacherl){
                    $sql = $db->prepare("UPDATE teacher_license 
                                        SET teacher_licenseID = :tlid,
                                            personalID = :pid,
                                            tl_licenseNO = :tl_licenseNO,
                                            tl_date = :tl_date,
                                            tl_since = :tl_since,
                                            tl_teaching_subject = :tl_teaching_subject
                                        WHERE personalID = :pid AND teacher_licenseID = :tlid; ");
                                        $sql->bindParam(':tlid',$teacherl['teacher_licenseID']);
                                        $sql->bindParam(':pid',$teacherl['personalID']);
                                        $sql->bindParam(':tl_licenseNO',$teacherl['tl_licenseNO']);
                                        $sql->bindParam(':tl_date',$teacherl['tl_date']);
                                        $sql->bindParam(':tl_since',$teacherl['tl_since']);
                                        $sql->bindParam(':tl_teaching_subject',$teacherl['tl_teaching_subject']);
                    $sql->execute();
                }
            }
            //---------------TEACHER_PERMISSION_LICENSE------------------//
            //---------------TEACHER_PERMISSION_LICENSE------------------//
            //---------------TEACHER_PERMISSION_LICENSE------------------//
            //---------------TEACHER_PERMISSION_LICENSE------------------//
            //---------------TEACHER_PERMISSION_LICENSE------------------//

            if(isset($data['teacher_permission_licenses'])){
                foreach($data['teacher_permission_licenses'] as $teacherpl){
                    $sql = $db->prepare("UPDATE teacher_permission_license 
                                        SET teacher_permissionNO = :teacher_permissionNO,
                                            tpl_date = :tpl_date,
                                            tpl_since = :tpl_since,
                                            tpl_currently_work = :tpl_currently_work,
                                            tpl_teacher_type = :tpl_teacher_type,
                                            tpl_district = :tpl_district,
                                            tpl_country = :tpl_country,
                                            tpl_teaching_subject = :tpl_teaching_subject,
                                            tpl_dischargeNO = :tpl_dischargeNO,
                                            tpl_discharge_date = :tpl_discharge_date,
                                            tpl_discharge_since = :tpl_discharge_since,
                                            tpl_discharge_motive = :tpl_discharge_motive,
                                            tpl_educational = :tpl_educational
                                        WHERE personalID = :pid AND teacher_permission_licenseID = :tplid; ");
                                        $sql->bindParam(':tplid',$teacherpl['teacher_permission_licenseID']);
                                        $sql->bindParam(':pid',$teacherpl['personalID']);
                                        $sql->bindParam(':teacher_permissionNO',$teacherpl['teacher_permissionNO']);
                                        $sql->bindParam(':tpl_date',$teacherpl['tpl_date']);
                                        $sql->bindParam(':tpl_since',$teacherpl['tpl_since']);
                                        $sql->bindParam(':tpl_currently_work',$teacherpl['tpl_currently_work']);
                                        $sql->bindParam(':tpl_teacher_type',$teacherpl['tpl_teacher_type']);
                                        $sql->bindParam(':tpl_district',$teacherpl['tpl_district']);
                                        $sql->bindParam(':tpl_country',$teacherpl['tpl_country']);
                                        $sql->bindParam(':tpl_teaching_subject',$teacherpl['tpl_teaching_subject']);
                                        $sql->bindParam(':tpl_dischargeNO',$teacherpl['tpl_dischargeNO']);
                                        $sql->bindParam(':tpl_discharge_date',$teacherpl['tpl_discharge_date']);
                                        $sql->bindParam(':tpl_discharge_since',$teacherpl['tpl_discharge_since']);
                                        $sql->bindParam(':tpl_discharge_motive',$teacherpl['tpl_discharge_motive']);
                                        $sql->bindParam(':tpl_educational',$teacherpl['tpl_educational']);
                    $sql->execute();
                }
            }
            //---------------HEADTEACHER_LICENSE------------------//
            //---------------HEADTEACHER_LICENSE------------------//
            //---------------HEADTEACHER_LICENSE------------------//
            //---------------HEADTEACHER_LICENSE------------------//
            //---------------HEADTEACHER_LICENSE------------------//

            if(isset($data['ht_licenses'])){
                    foreach($data['ht_licenses'] as $ht_license){
                        $sql = $db->prepare("UPDATE ht_license 
                                            SET HT_licenseNO = :HT_licenseNO,
                                                HT_date = :HT_date,
                                                HT_date_since = :HT_date_since,
                                                HT_dischargeNO = :HT_dischargeNO,
                                                HT_discharge_date = :HT_discharge_date,
                                                HT_discharge_since = :HT_discharge_since,
                                                HT_discharge_motive = :HT_discharge_motive
                                            WHERE personalID = :pid AND HT_licenseID = :htid; ");
                                            $sql->bindParam(':htid',$ht_license['HT_licenseID']);
                                            $sql->bindParam(':HT_licenseNO',$ht_license['HT_licenseNO']);
                                            $sql->bindParam(':pid',$ht_license['personalID']);
                                            $sql->bindParam(':HT_date',$ht_license['HT_date']);
                                            $sql->bindParam(':HT_date_since',$ht_license['HT_date_since']);
                                            $sql->bindParam(':HT_dischargeNO',$ht_license['HT_dischargeNO']);
                                            $sql->bindParam(':HT_discharge_since',$ht_license['HT_discharge_since']);
                                            $sql->bindParam(':HT_discharge_date',$ht_license['HT_discharge_date']);
                                            $sql->bindParam(':HT_discharge_motive',$ht_license['HT_discharge_motive']);
                        $sql->execute();
                    }
            }
            //---------------APPOINTMENT------------------//
            //---------------APPOINTMENT------------------//
            //---------------APPOINTMENT------------------//
            //---------------APPOINTMENT------------------//
            //---------------APPOINTMENT------------------//

            if(isset($data['apps'])){
                foreach($data['apps'] as $app){
                    $sql = $db->prepare("UPDATE appointment 
                                        SET appointmentNO = :appointmentNO,
                                            app_date = :app_date,
                                            app_since = :app_since,
                                            app_currently_work = :app_currently_work,
                                            app_teacher_type = :app_teacher_type,
                                            app_district = :app_district,
                                            app_country = :app_country,
                                            app_educational = :app_educational,
                                            app_teaching_subject = :app_teaching_subject,
                                            app_dischargeNO = :app_dischargeNO,
                                            app_discharge_date = :app_discharge_date,
                                            app_discharge_since = :app_discharge_since,
                                            app_discharge_motive = :app_discharge_motive
                                        WHERE personalID = :pid AND appointmentID = :aid; ");
                                        $sql->bindParam(':aid',$app['appointmentID']);
                                        $sql->bindParam(':pid',$app['personalID']);
                                        $sql->bindParam(':appointmentNO',$app['appointmentNO']);
                                        $sql->bindParam(':app_date',$app['app_date']);
                                        $sql->bindParam(':app_since',$app['app_since']);
                                        $sql->bindParam(':app_currently_work',$app['app_currently_work']);
                                        $sql->bindParam(':app_teacher_type',$app['app_teacher_type']);
                                        $sql->bindParam(':app_district',$app['app_district']);
                                        $sql->bindParam(':app_country',$app['app_country']);
                                        $sql->bindParam(':app_educational',$app['app_educational']);
                                        $sql->bindParam(':app_teaching_subject',$app['app_teaching_subject']);
                                        $sql->bindParam(':app_dischargeNO',$app['app_dischargeNO']);
                                        $sql->bindParam(':app_discharge_date',$app['app_discharge_date']);
                                        $sql->bindParam(':app_discharge_since',$app['app_discharge_since']);
                                        $sql->bindParam(':app_discharge_motive',$app['app_discharge_motive']);
                    $sql->execute();
                    }
            }
            //---------------PORTFOLIO------------------//
            //---------------PORTFOLIO------------------//
            //---------------PORTFOLIO------------------//
            //---------------PORTFOLIO------------------//
            //---------------PORTFOLIO------------------//

            if(isset($data['portfolios'])){
                foreach($data['portfolios'] as $portfolio){
                    $sql = $db->prepare("UPDATE portfolio 
                                        SET
                                            portfolio_name = :portfolio_name
                                        WHERE personalID = :pid AND portfolioID = :portfolioID; ");
                                        $sql->bindParam(':portfolioID',$portfolio['portfolioID']);
                                        $sql->bindParam(':pid',$portfolio['personalID']);
                                        $sql->bindParam(':portfolio_name',$portfolio['portfolio_name']);
                    $sql->execute();
                    }
            } 
            //---------------INSIGNIA------------------//
            //---------------INSIGNIA------------------//
            //---------------INSIGNIA------------------//
            //---------------INSIGNIA------------------//
            //---------------INSIGNIA------------------//
            if(isset($data['insignias'])){
                foreach($data['insignias'] as $insignia){
                    $sql = $db->prepare("UPDATE insignia 
                                        SET insignia_name = :insignia_name
                                        WHERE personalID = :pid AND insigniaID = :insigniaID; ");
                                        $sql->bindParam(':insigniaID',$insignia['insigniaID']);
                                        $sql->bindParam(':pid',$insignia['personalID']);
                                        $sql->bindParam(':insignia_name',$insignia['insignia_name']);
                    $sql->execute();
                    }
            }
            //---------------PUNISHMENT------------------//
            //---------------PUNISHMENT------------------//
            //---------------PUNISHMENT------------------//
            //---------------PUNISHMENT------------------//
            //---------------PUNISHMENT------------------//
            if(isset($data['punishments'])){
                    foreach($data['punishments'] as $punishment){
                        $sql = $db->prepare("UPDATE punishment 
                                            SET punishment_name = :punishment_name
                                            WHERE personalID = :pid AND punishmentID = :pmid; ");
                                            $sql->bindParam(':pmid',$punishment['punishmentID']);
                                            $sql->bindParam(':pid',$punishment['personalID']);
                                            $sql->bindParam(':punishment_name',$punishment['punishment_name']);
                        $sql->execute();
                        }
            }
            $db = null;
            if (!$sql) {
                return ['data' => [], 'require' => false];
            } else {
                return ['data' => [], 'require' => true];
            }
        } catch (PDOException $e) {
            $db = null;
            echo $e->getMessage();
            return ['data' => [], 'require' => false];
        }
    }
    
    public function insertUser($data)
    {
        try {
            //---------------USER------------------//
            //---------------USER------------------//
            //---------------USER------------------//
            //---------------USER------------------//
            //---------------USER------------------//
            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("INSERT INTO tb_user 
            (personalID, citizenID, thai_fname, thai_lname, eng_fname, eng_lname, nationality, bdate, father_fname, father_lname, mother_fname, mother_lname, courseID, prefixID)
            VALUES
            (:personalid, :citizenid, :thaifname, :thailname, :engfname, :englname, :nationality, :bdate, :ffname, :flname, :mfname, :mlname, :cid, :pid);");
            $sql->bindParam(':personalid', $data['personalID']);
            $sql->bindParam(':citizenid', $data['citizenID']);
            $sql->bindParam(':thaifname', $data['thai_fname']);
            $sql->bindParam(':thailname', $data['thai_lname']);
            $sql->bindParam(':engfname', $data['eng_fname']);
            $sql->bindParam(':englname', $data['eng_lname']);
            $sql->bindParam(':nationality', $data['nationality']);
            $sql->bindParam(':bdate', $data['bdate']);
            $sql->bindParam(':ffname', $data['father_fname']);
            $sql->bindParam(':flname', $data['father_lname']);
            $sql->bindParam(':mfname', $data['mother_fname']);
            $sql->bindParam(':mlname', $data['mother_lname']);
            $sql->bindParam(':cid', $data['courseID']);
            $sql->bindParam(':pid', $data['prefixID']);
            $sql->execute();
            //---------------ADDRESS------------------//
            //---------------ADDRESS------------------//
            //---------------ADDRESS------------------//
            //---------------ADDRESS------------------//
            //---------------ADDRESS------------------//
            $sql = $db->prepare("INSERT INTO useraddress 
            (addressID, personalID, village_no, house_no, alley, road, sub_district, sub_area, country, postal_code, tel)
            VALUES
            (:aid, :pid, :villageno, :houseno, :alley, :road, :subdistrict, :subarea, :country, :postalcode, :tel);");
            $sql->bindParam(':aid', $data['addressID']);
            $sql->bindParam(':pid', $data['personalID']);
            $sql->bindParam(':villageno', $data['village_no']);
            $sql->bindParam(':houseno', $data['house_no']);
            $sql->bindParam(':alley', $data['alley']);
            $sql->bindParam(':road', $data['road']);
            $sql->bindParam(':subdistrict', $data['sub_district']);
            $sql->bindParam(':subarea', $data['sub_area']);
            $sql->bindParam(':country', $data['country']);
            $sql->bindParam(':postalcode', $data['postal_code']);
            $sql->bindParam(':tel', $data['tel']);
            $sql->execute();
            //---------------USER_POSITION------------------//
            //---------------USER_POSITION------------------//
            //---------------USER_POSITION------------------//
            //---------------USER_POSITION------------------//
            $sql = $db->prepare("INSERT INTO user_position 
            (positionID, personalID)
            VALUES
            (:positionID, :personalID);");
            $sql->bindParam(':positionID', $data['positionID']);
            $sql->bindParam(':personalID', $data['personalID']);
            $sql->execute();

            //---------------EDUCATIONS------------------//
            //---------------EDUCATIONS------------------//
            //---------------EDUCATIONS------------------//
            //---------------EDUCATIONS------------------//
            //---------------EDUCATIONS------------------//

            if(isset($data['educations'])){
                foreach($data['educations'] as $education){
                    $sql = $db->prepare("INSERT INTO education 
                                        (personalID, educational_typeID, educational_name, educational_major, institution_name, graduate_country, graduate_date)
                                        VALUES
                                        (:pid, :eid, :educational_name, :educational_major, :institution_name, :graduate_country, :graduate_date);");
                    $sql->bindParam(':eid',$education['educational_typeID']);
                    $sql->bindParam(':pid',$education['personalID']);
                    $sql->bindParam(':educational_name',$education['educational_name']);
                    $sql->bindParam(':educational_major',$education['educational_major']);
                    $sql->bindParam(':institution_name',$education['institution_name']);
                    $sql->bindParam(':graduate_country',$education['graduate_country']);
                    $sql->bindParam(':graduate_date',$education['graduate_date']);
                    $sql->execute();
                }
            }
            //---------------TRAINNING------------------//
            //---------------TRAINNING------------------//
            //---------------TRAINNING------------------//
            //---------------TRAINNING------------------//
            //---------------TRAINNING------------------//
            
            if(isset($data['trainings'])){
                foreach($data['trainings'] as $training){
                    $sql = $db->prepare("INSERT INTO training_certificate 
                                        (personalID, training_topic, training_agency, country_agency, training_date, training_end_date) 
                                        VALUES (:pid, :training_topic, :training_agency, :country_agency, :training_date, :training_end_date); ");
                    $sql->bindParam(':pid',$training['personalID']);
                    $sql->bindParam(':training_topic',$training['training_topic']);
                    $sql->bindParam(':country_agency',$training['country_agency']);
                    $sql->bindParam(':training_agency',$training['training_agency']);
                    $sql->bindParam(':training_date',$training['training_date']);
                    $sql->bindParam(':training_end_date',$training['training_end_date']);
                    $sql->execute();
                }
            }
            //---------------TEACHER_LICENSE------------------//
            //---------------TEACHER_LICENSE------------------//
            //---------------TEACHER_LICENSE------------------//
            //---------------TEACHER_LICENSE------------------//
            //---------------TEACHER_LICENSE------------------//

            if(isset($data['teacher_licenses'])){
                foreach($data['teacher_licenses'] as $teacherl){
                    $sql = $db->prepare("INSERT INTO teacher_license 
                                            (teacher_licenseID, personalID, tl_licenseNO, tl_date, tl_since, tl_teaching_subject) 
                                            VALUES 
                                            (:tlid, :pid, :tl_licenseNO, :tl_date, :tl_since, :tl_teaching_subject)");
                    $sql->bindParam(':tlid',$teacherl['teacher_licenseID']);
                    $sql->bindParam(':pid',$teacherl['personalID']);
                    $sql->bindParam(':tl_licenseNO',$teacherl['tl_licenseNO']);
                    $sql->bindParam(':tl_date',$teacherl['tl_date']);
                    $sql->bindParam(':tl_since',$teacherl['tl_since']);
                    $sql->bindParam(':tl_teaching_subject',$teacherl['tl_teaching_subject']);
                    $sql->execute();
                }
            }
            //---------------TEACHER_PERMISSION_LICENSE------------------//
            //---------------TEACHER_PERMISSION_LICENSE------------------//
            //---------------TEACHER_PERMISSION_LICENSE------------------//
            //---------------TEACHER_PERMISSION_LICENSE------------------//
            //---------------TEACHER_PERMISSION_LICENSE------------------//

            if(isset($data['teacher_permission_licenses'])){
                foreach($data['teacher_permission_licenses'] as $teacherpl){
                    $sql = $db->prepare("INSERT INTO teacher_permission_license 
                                        (personalID, teacher_permissionNO, tpl_date, tpl_since, tpl_currently_work, tpl_teacher_type, tpl_district, tpl_country, tpl_teaching_subject, tpl_dischargeNO, tpl_discharge_date, tpl_discharge_since, tpl_discharge_motive, tpl_educational)
                                        VALUES
                                        (:pid, :teacher_permissionNO, :tpl_date, :tpl_since, :tpl_currently_work, :tpl_teacher_type, :tpl_district, :tpl_country, :tpl_teaching_subject, :tpl_dischargeNO, :tpl_discharge_date, :tpl_discharge_since, :tpl_discharge_motive, :tpl_educational)
                                        ");
                    $sql->bindParam(':pid',$teacherpl['personalID']);
                    $sql->bindParam(':teacher_permissionNO',$teacherpl['teacher_permissionNO']);
                    $sql->bindParam(':tpl_date',$teacherpl['tpl_date']);
                    $sql->bindParam(':tpl_since',$teacherpl['tpl_since']);
                    $sql->bindParam(':tpl_currently_work',$teacherpl['tpl_currently_work']);
                    $sql->bindParam(':tpl_teacher_type',$teacherpl['tpl_teacher_type']);
                    $sql->bindParam(':tpl_district',$teacherpl['tpl_district']);
                    $sql->bindParam(':tpl_country',$teacherpl['tpl_country']);
                    $sql->bindParam(':tpl_teaching_subject',$teacherpl['tpl_teaching_subject']);
                    $sql->bindParam(':tpl_dischargeNO',$teacherpl['tpl_dischargeNO']);
                    $sql->bindParam(':tpl_discharge_date',$teacherpl['tpl_discharge_date']);
                    $sql->bindParam(':tpl_discharge_since',$teacherpl['tpl_discharge_since']);
                    $sql->bindParam(':tpl_discharge_motive',$teacherpl['tpl_discharge_motive']);
                    $sql->bindParam(':tpl_educational',$teacherpl['tpl_educational']);
                    $sql->execute();
                }
            }
            //---------------HEADTECHER_LICENSE------------------//
            //---------------HEADTECHER_LICENSE------------------//
            //---------------HEADTECHER_LICENSE------------------//
            //---------------HEADTECHER_LICENSE------------------//
            //---------------HEADTECHER_LICENSE------------------//
            
            if(isset($data['ht_licenses'])){
                foreach($data['ht_licenses'] as $ht_license){
                    $sql = $db->prepare("INSERT INTO ht_license 
                                            (HT_licenseNO, personalID, HT_date, HT_date_since, HT_dischargeNO, HT_discharge_date, HT_discharge_since, HT_discharge_motive)
                                            VALUES (:HT_licenseNO, :pid, :HT_date, :HT_date_since, :HT_dischargeNO, :HT_discharge_date, :HT_discharge_since, :HT_discharge_motive)");
                    $sql->bindParam(':HT_licenseNO',$ht_license['HT_licenseNO']);
                    $sql->bindParam(':pid',$ht_license['personalID']);
                    $sql->bindParam(':HT_date',$ht_license['HT_date']);
                    $sql->bindParam(':HT_date_since',$ht_license['HT_date_since']);
                    $sql->bindParam(':HT_dischargeNO',$ht_license['HT_dischargeNO']);
                    $sql->bindParam(':HT_discharge_since',$ht_license['HT_discharge_since']);
                    $sql->bindParam(':HT_discharge_date',$ht_license['HT_discharge_date']);
                    $sql->bindParam(':HT_discharge_motive',$ht_license['HT_discharge_motive']);
                    $sql->execute();
                }
            }
            //---------------APPIONTMENT------------------//
            //---------------APPIONTMENT------------------//
            //---------------APPIONTMENT------------------//
            //---------------APPIONTMENT------------------//
            //---------------APPIONTMENT------------------//

            if(isset($data['apps'])){
                foreach($data['apps'] as $app){
                    $sql = $db->prepare("INSERT INTO appointment (personalID, appointmentNO, app_date, app_since, app_currently_work, app_teacher_type, app_district, app_country, app_educational, app_teaching_subject, app_dischargeNO, app_discharge_date, app_discharge_since, app_discharge_motive)
                                         VALUES (:pid, :appointmentNO, :app_date, :app_since, :app_currently_work, :app_teacher_type, :app_district, :app_country, :app_educational, :app_teaching_subject, :app_dischargeNO, :app_discharge_date, :app_discharge_since, :app_discharge_motive);");
                    $sql->bindParam(':pid',$app['personalID']);
                    $sql->bindParam(':appointmentNO',$app['appointmentNO']);
                    $sql->bindParam(':app_date',$app['app_date']);
                    $sql->bindParam(':app_since',$app['app_since']);
                    $sql->bindParam(':app_currently_work',$app['app_currently_work']);
                    $sql->bindParam(':app_teacher_type',$app['app_teacher_type']);
                    $sql->bindParam(':app_district',$app['app_district']);
                    $sql->bindParam(':app_country',$app['app_country']);
                    $sql->bindParam(':app_educational',$app['app_educational']);
                    $sql->bindParam(':app_teaching_subject',$app['app_teaching_subject']);
                    $sql->bindParam(':app_dischargeNO',$app['app_dischargeNO']);
                    $sql->bindParam(':app_discharge_date',$app['app_discharge_date']);
                    $sql->bindParam(':app_discharge_since',$app['app_discharge_since']);
                    $sql->bindParam(':app_discharge_motive',$app['app_discharge_motive']);
                    $sql->execute();
                }
            }
            //---------------PORRTFOLIO------------------//
            //---------------PORRTFOLIO------------------//
            //---------------PORRTFOLIO------------------//
            //---------------PORRTFOLIO------------------//
            //---------------PORRTFOLIO------------------//

            if(isset($data['portfolios'])){
                foreach($data['portfolios'] as $portfolio){
                    $sql = $db->prepare("INSERT INTO portfolio (personalID, portfolio_name) 
                                         VALUES (:pid, :portfolio_name); ");
                    $sql->bindParam(':pid',$portfolio['personalID']);
                    $sql->bindParam(':portfolio_name',$portfolio['portfolio_name']);
                    $sql->execute();
                }
            }
            //---------------INSIGNIA------------------//
            //---------------INSIGNIA------------------//
            //---------------INSIGNIA------------------//
            //---------------INSIGNIA------------------//
            //---------------INSIGNIA------------------//

            if(isset($data['insignias'])){
                foreach($data['insignias'] as $insignia){
                    $sql = $db->prepare("INSERT INTO insignia 
                                          (personalID, insignia_name) 
                                          VALUES (:pid, :insignia_name);");
                    $sql->bindParam(':pid', $insignia['personalID']);
                    $sql->bindParam(':insignia_name', $insignia['insignia_name']);
                    $sql->execute();
                }
            } 
            //---------------PUNISHMENT------------------//
            //---------------PUNISHMENT------------------//
            //---------------PUNISHMENT------------------//
            //---------------PUNISHMENT------------------//
            //---------------PUNISHMENT------------------//
            if(isset($data['punishments'])){
                foreach($data['punishments'] as $punishment){
                    $sql = $db->prepare("INSERT INTO punishment (personalID, punishment_name)
                                         VALUES (:pid, :punishment_name)");
                    $sql->bindParam(':pid', $punishment['personalID']);
                    $sql->bindParam(':punishment_name', $punishment['punishment_name']);
                    $sql->execute();
                }
            }
            

            $db = null;
            if (!$sql) {

                return ['data' => [], 'require' => false];
            } else {

                return ['data' => [], 'require' => true];
            }
        } catch (PDOException $e) {
            $db = null;
            echo $e->getMessage();
            return ['data' => [], 'require' => false];

        }
    }
    
    public function checkLogin($data)
    {
        try {
            // Get DB Object
            $db = new db();
            // connect to DB
            $db = $db->connect();
           
            // query
            $password = md5($data['password']);
            $sql = $db->prepare("SELECT * FROM tb_user WHERE username = :username AND password = :pass");
            $sql->bindParam(':username',$data['username']);
            $sql->bindParam(':pass',$password);
            $sql->execute();
            $tb_user = $sql->fetchAll(PDO::FETCH_OBJ);
            if (!$tb_user) {
                $db = null;
                return ['data' => [], 'require' => false];
            }else{
                $jwt = new JwtHandler();
                $token = $jwt->_jwt_encode_data("http://localhost/ktec-Server/public/", array("id" => $tb_user[0]->username));
                $sql = $db->prepare("SELECT *,
                IFNULL((SELECT position_name FROM position WHERE position.positionID = user_position.positionID),user_position.positionID)AS position_name
                            FROM user_position 
                            WHERE personalID =(
                            select personalID FROM tb_user where username = :username
                            ) ");
                $sql->bindParam(':username',$tb_user[0]->username);
                $sql->execute();
                $position = $sql->fetchAll(PDO::FETCH_OBJ);
                $tmp = [];
                foreach($position as $pos){
                    $sql = $db->prepare("SELECT *,
                                        ifnull((SELECT menu_name FROM menu WHERE menu.menuID = permission.menuID),permission.menuID)as menu_name,
                                        ifnull((SELECT menu_group FROM menu WHERE menu.menuID = permission.menuID),permission.menuID)as menu_group 
                                        FROM permission 
                                        WHERE positionID = :position_id;");
                    $sql->bindParam(':position_id',$pos->positionID);
                    $sql->execute();
                    $permission = $sql->fetchAll(PDO::FETCH_OBJ);
                    array_push($tmp,['position_id'=>$pos->positionID,'position_name'=>$pos->position_name,'permission'=>$permission]);
                }
            }
               return ['data' =>$tb_user,'require' => true , 'token' => $token,'permission'=> $tmp ];
        } catch (PDOException $e) {
            $db = null;
            return [ 'data' => [], 'require' => false];
        }
    }
    
    public function updateUserByCitizenID($data)
    {
        try {

            $db = new db();
            $db = $db->connect();
            $password = md5($data['password']);
            $sql = $db->prepare("UPDATE tb_user SET `username`=:username, `password`=:pass 
                                WHERE `citizenID`=:citizenID");
            $sql->bindParam(':citizenID', $data['citizenID']);
            $sql->bindParam(':username', $data['username']);
            $sql->bindParam(':pass', $password);
            
            $sql->execute();
            
            $db = null;
            if (!$sql) {

                return ['data' => [], 'require' => false];
            } else {

                return ['data' => [], 'require' => true];
            }
        } catch (PDOException $e) {
            $db = null;
            echo $e->getMessage();
            return ['data' => [], 'require' => false];

        }
    }

    public function deleteUserByid($data)
    {
        try {
            $db = new db();
            $db = $db->connect();
            $sql = $db->prepare("DELETE FROM useraddress WHERE personalID = :pid; ");
            $sql->bindParam(':pid', $data['personalID']);
            $sql->execute();
            $sql = $db->prepare("DELETE FROM user_position WHERE personalID = :pid; ");
            $sql->bindParam(':pid', $data['personalID']);
            $sql->execute();
            $sql = $db->prepare("DELETE FROM tb_user WHERE personalID = :pid; ");
            $sql->bindParam(':pid', $data['personalID']);
            $sql->execute();
            $db = null;
            if (!$sql) {
                return [ 'require' => false];
            } else {
                return [ 'require' => true];
            }
        } catch (PDOException $e) {
            $db = null;
            echo $e->getMessage();
            return ['require' => false];
        }
    }

}