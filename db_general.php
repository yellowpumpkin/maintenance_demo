<?php 
    session_start();
    require_once 'config/db.php';

    if (isset($_POST['insert_department'])) {
        $department_name = $_POST['department_name'];

        if (empty($department_name)) {
            $_SESSION['error'] = 'กรุณากรอกแผนกงาน ';
            header("location: manage_department.php");
        } else {
            $check_department = $conn->prepare("SELECT department_name FROM tbl_department WHERE department_name = :department_name");
            $check_department->bindParam(":department_name", $department_name);
            $check_department->execute();
            $row = $check_department->fetch(PDO::FETCH_ASSOC);
            if ($row['department_name'] == $department_name) {
                $_SESSION['warning'] = "มีข้อมูลนี้อยู่ในระบบแล้ว";
                header("location:  manage_department.php");
            } else if (!isset($_SESSION['error'])) {
                   
                    $stmt = $conn->prepare("INSERT INTO tbl_department(department_name) 
                                            VALUES(:department_name)");
                    
                    $stmt->bindParam(":department_name", $department_name);
                    $stmt->execute();
                    $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว!";
                    header("location: manage_department.php");
                } 
            } 
    } else if (isset($_POST['insert_status'])) {
        $status_name = $_POST['status_name'];
        if (empty($status_name)) {
            $_SESSION['error'] = 'กรุณากรอกสถานะ';
            header("location: manage_status.php");
        } else {
            $check_status = $conn->prepare("SELECT status_name FROM tbl_status WHERE status_name = :status_name");
            $check_status->bindParam(":status_name", $status_name);
            $check_status->execute();
            $row = $check_status->fetch(PDO::FETCH_ASSOC);
            if ($row['status_name'] == $status_name) {
                $_SESSION['warning'] = "มีข้อมูลนี้อยู่ในระบบแล้ว";
                header("location:  manage_status.php");
            } else if (!isset($_SESSION['error'])) {
                   
                    $stmt = $conn->prepare("INSERT INTO tbl_status(status_name) 
                                            VALUES(:status_name)");
                    
                    $stmt->bindParam(":status_name", $status_name);
                    $stmt->execute();
                    $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว!";
                    header("location: manage_status.php");
                } 
            } 
    } else   if (isset($_POST['insert_info_maintenance'])) {
        // $date_start = $_POST['date_start'];
        $date_end = $_POST['date_end'];
        $machine_no = $_POST['machine_no'];
        $machine_name = $_POST['machine_name'];
        $problem_case = $_POST['problem_case'];
        $place_name =  $_POST['place_name'];
        $agency = $_POST['agency'];
        $urgency = $_POST['urgency'];
        $user =  $_POST['username_case'];
        $status = '1';
        $case_status = '0';
           
        if (empty($machine_name)) {
            $_SESSION['error'] = 'กรุณากรอก machine_name';
            header("location: users_maintenance.php");
        } else {
            try {
              if (!isset($_SESSION['error'])) {
     
                    $stmt = $conn->prepare("INSERT INTO tbl_case( date_end, machine_no, machine_name ,problem_case, place_name, agency, urgency , user_id  ,status_id ,case_status) 
                                            VALUES( :date_end, :machine_no, :machine_name ,:problem_case, :place_name, :agency, :urgency, (SELECT id FROM tbl_users WHERE id = (SELECT id FROM tbl_users WHERE username=:username_case))  ,:status , :case_status)");
                    $stmt->bindParam(":date_end", $date_end);
                    $stmt->bindParam(":machine_no", $machine_no);
                    $stmt->bindParam(":machine_name", $machine_name);
                    $stmt->bindParam(":problem_case", $problem_case);
                    $stmt->bindParam(":place_name", $place_name);
                    $stmt->bindParam(":agency", $agency);
                    $stmt->bindParam(":urgency", $urgency);
                    $stmt->bindParam(":username_case", $user);
                    $stmt->bindParam(":status", $status);
                    $stmt->bindParam(":case_status", $case_status);
                    $stmt->execute();
                    $_SESSION['success'] = "บันทึกข้อมูลเรียบร้อย";
                    header("location: users_maintenance.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: users_maintenance.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
        }
    } 

} else if (isset($_POST['update_status'])) {
    $sid = $_POST['sid'];
    $status_name = $_POST['status_name'];

    $check_status_name = $conn->prepare("SELECT status_name FROM tbl_status WHERE status_name = :status_name");
    $check_status_name ->bindParam(":status_name", $status_name);
    $check_status_name->execute();
    $row = $check_status_name->fetch(PDO::FETCH_ASSOC);
    
    if ($row['status_name'] == $status_name) {
        $_SESSION['warning'] = "มีข้อมูลนี้อยู่ในระบบแล้ว";
        header("location:  manage_status.php");
    } else {
    
        $sql = $conn->prepare("UPDATE tbl_status SET status_name=:status_name   WHERE sid = $sid ");
    
        $sql->bindParam(":status_name",  $status_name );
        $sql->execute();

            if ($sql) {
                $_SESSION['success'] = "อัพเดทข้อมูลสำเร็จ";
                header("location: manage_status.php");
            } else {
                $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ";
                header("location: manage_status.php");
            }
        }
    } else if (isset($_POST['update_department'])) {
        $department_id = $_POST['department_id'];
        $department_name = $_POST['department_name'];
    
        $check_department_name = $conn->prepare("SELECT department_name FROM tbl_department WHERE department_name = :department_name");
        $check_department_name ->bindParam(":department_name", $department_name);
        $check_department_name->execute();
        $row = $check_department_name->fetch(PDO::FETCH_ASSOC);
        
        if ($row['department_name'] == $department_name) {
            $_SESSION['warning'] = "มีข้อมูลนี้อยู่ในระบบแล้ว";
            header("location:  manage_department.php");
        } else {
        
            $sql = $conn->prepare("UPDATE tbl_department SET department_name=:department_name   WHERE department_id = $department_id ");
        
            $sql->bindParam(":department_name",  $department_name );
            $sql->execute();
    
                if ($sql) {
                    $_SESSION['success'] = "อัพเดทข้อมูลสำเร็จ";
                    header("location: manage_department.php");
                } else {
                    $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ";
                    header("location: manage_department.php");
                }
            }
        } else   if (isset($_POST['update_maintenance'])) {
            $case_id = $_POST['case_id'];
            $status_id = $_POST['status_id'];
            $date_of_operation = $_POST['date_of_operation'];
            $date_completion = $_POST['date_completion'];
            $problems_found = $_POST['problems_found'];
            $details = $_POST['details'];
            $spare_part = $_POST['spare_part'];
            $note = $_POST['note'];
        
            $sql = $conn->prepare("UPDATE tbl_case SET status_id=(SELECT sid FROM tbl_status WHERE sid =
            
             (SELECT sid FROM tbl_status WHERE status_name=:status_id))  , date_operation = :date_of_operation , date_completion= :date_completion , problems_found= :problems_found , details= :details , spare_part= :spare_part , note= :note WHERE case_id = $case_id ");
            $sql->bindParam(":status_id",  $status_id );
            $sql->bindParam(":date_of_operation",  $date_of_operation );
            $sql->bindParam(":date_completion",  $date_completion );
            $sql->bindParam(":problems_found", $problems_found);
            $sql->bindParam(":details", $details);
            $sql->bindParam(":spare_part", $spare_part);
            $sql->bindParam(":note", $note);
            $sql->execute();
    
            if ($sql) {
                $_SESSION['success'] = "อัพเดทข้อมูลสำเร็จ";
                header("location: maintenance_view.php");
            } else {
                $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ";
                header("location: maintenance_view.php");
            }
        } else   if (isset($_POST['update_status_maintenance'])) {
            $case_id = $_POST['case_id'];
            $status_id = $_POST['status_id'];
            $tech = $_POST['technician_name'];
        
    
            $sql = $conn->prepare("UPDATE tbl_case SET status_id=(SELECT sid FROM tbl_status WHERE sid = (SELECT sid FROM tbl_status WHERE status_name=:status_id))  , tech= :technician_name  WHERE case_id = $case_id ");
            $sql->bindParam(":status_id",  $status_id );
            $sql->bindParam(":technician_name",  $tech );
            $sql->execute();
    
            if ($sql) {
                $_SESSION['success'] = "อัพเดทข้อมูลสำเร็จ";
                header("location: manage_maintenance.php");
            } else {
                $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ";
                header("location: manage_maintenance.php");
            }

        } else   if (isset($_POST['case_status'])) {
            $case_id = $_POST['case_id'];
            $case_status = $_POST['case_status'];
           
        
    
            $sql = $conn->prepare("UPDATE tbl_case SET case_status = :case_status  WHERE case_id = $case_id ");
            $sql->bindParam(":case_status",  $case_status );
            $sql->execute();
    
            if ($sql) {
                $_SESSION['success'] = "อัพเดทข้อมูลสำเร็จ";
                header("location: maintenance_all.php");
            } else {
                $_SESSION['error'] = "อัพเดทข้อมูลไม่สำเร็จ";
                header("location: maintenance_all.php");
            }
        }
    
    

?>