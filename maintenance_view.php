<?php 

session_start();
require_once 'config/db.php';
if (!isset($_SESSION['admin_login']) and !isset($_SESSION['leader_login']) and !isset($_SESSION['technician_login']) and !isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
} 

$select_stmt = $conn->query("SELECT * FROM tbl_case 
INNER JOIN tbl_users ON user_id = id 
INNER JOIN tbl_status ON status_id = sid 
INNER JOIN tbl_department ON department = department_id limit 10");
$select_stmt->execute();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">

    <!-- cdn data table   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />

    <!-- cdn feather icons   -->
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        padding: 90px 0 0;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        z-index: 99;
    }

    @media (max-width: 767.98px) {
        .sidebar {
            top: 11.5rem;
            padding: 0;
        }
    }

    .navbar {
        box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .1);
    }

    @media (min-width: 767.98px) {
        .navbar {
            top: 0;
            position: sticky;
            z-index: 999;
        }
    }

    .sidebar .nav-link {
        color: #333;
    }

    .sidebar .nav-link.active {
        color: #0d6efd;
    }
    </style>
</head>

<body>
    <?php 
        if (isset($_SESSION['admin_login'])) {
            $admin_id = $_SESSION['admin_login'];
            $stmt = $conn->query("SELECT * FROM tbl_users WHERE id = $admin_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        else  if  (isset($_SESSION['leader_login'])) {
            $leader_id = $_SESSION['leader_login'];
            $stmt = $conn->query("SELECT * FROM tbl_users WHERE id = $leader_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        else  if  (isset($_SESSION['technician_login'])) {
            $technician_id = $_SESSION['technician_login'];
            $stmt = $conn->query("SELECT * FROM tbl_users WHERE id = $technician_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        else  if  (isset($_SESSION['user_login'])) {
            $user_id = $_SESSION['user_login'];
            $stmt = $conn->query("SELECT * FROM tbl_users WHERE id = $user_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
    ?>
    <nav class="navbar navbar-light bg-light p-3">
        <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
            <a class="navbar-brand" href="admin.php">
                <?php echo $row['urole'] ?>
            </a>
            <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse"
                data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="col-12 col-md-4 col-lg-2">
            <h3> Dashboard</h3>
        </div>
        <div class="col-12 col-md-5 col-lg-8 d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                    Hello, <?php echo $row['firstname'] . ' ' . $row['lastname'] ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="signout.php">Sign out</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <?php if (isset($_SESSION['admin_login'])) { ?>
                            <a class="nav-link active" aria-current="page" href=admin.php>
                                <i data-feather="rewind"></i>
                                <span class="ml-2">BACK</span>
                            </a>
                            <?php } ?>

                            <?php if (isset($_SESSION['leader_login'])) { ?>
                            <a class="nav-link active" aria-current="page" href=leader.php>
                                <i data-feather="rewind"></i>
                                <span class="ml-2">BACK</span>
                            </a>
                            <?php } ?>

                            <?php if (isset($_SESSION['technician_login'])) { ?>
                            <a class="nav-link active" aria-current="page" href=technician.php>
                                <i data-feather="rewind"></i>
                                <span class="ml-2">BACK</span>
                            </a>
                            <?php } ?>

                            <?php if (isset($_SESSION['user_login'])) { ?>
                            <a class="nav-link active" aria-current="page" href=users.php>
                                <i data-feather="rewind"></i>
                                <span class="ml-2">BACK</span>
                            </a>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <div class="row">
                    <div class="col-12 ">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title text-center">ข้อมูลงานแจ้งซ่อม</h4>
                            </div>

                            <div class="card-body">
                                <?php if(isset($_SESSION['error'])) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                                </div>
                                <?php } ?>
                                <?php if(isset($_SESSION['success'])) { ?>
                                <div class="alert alert-success" role="alert">
                                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                                </div>
                                <?php } ?>
                                <?php if(isset($_SESSION['warning'])) { ?>
                                <div class="alert alert-warning" role="alert">
                                    <?php 
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                    ?>
                                </div>
                                <?php } ?>
                                <!-- <button type="button" class="btn btn-secondary">รอตรวจสอบ</button> -->

                                <div class="table-responsive">
                                    <table id="myTable" class="display" style="width: 100%;">
                                        <thead>
                                        <th>No</th>
                                            <th>วันที่แจ้งซ่อม</th>
                                            <th>หมายเลขเครื่อง</th>
                                            <th>ชื่อเครื่อง</th>
                                            <th>อาการเบื้องต้น</th>
                                            <th>วันที่ต้องการใช้/ความเร่งด่วน</th>
                                            <th>ผู้แจ้งซ่อม</th>
                                            <th>ช่างเทคนิค</th>
                                            <th>สถานะ</th>
                                            
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $select_stmt = $conn->query("SELECT * FROM tbl_case 
                                                INNER JOIN tbl_users ON user_id = id 
                                                INNER JOIN tbl_status ON status_id = sid 
                                                INNER JOIN tbl_department ON department = department_id where case_status = '0'
                                                ");
                                                $select_stmt->execute();
                                                $cases = $select_stmt->fetchAll();

                                                $sth = $conn->prepare("SELECT status_name FROM tbl_status");
                                                $sth->execute();

                                                /* Fetch all of the remaining rows in the result set */
                                                $status = $sth->fetchAll(PDO::FETCH_COLUMN, 0);

                                                foreach($cases as $row) {
                                                    ?>
                                            <tr>
                                                <td><?php echo $row["case_id"]; ?></td>
                                                <td><?php echo $row["date_start"]; ?></td>
                                                <td><?php echo $row["machine_no"]; ?></td>
                                                <td><?php echo $row["machine_name"]; ?></td>
                                                <td><?php echo $row["problem_case"]; ?></td>
                                          
                                                <td><?php echo $row["date_end"]; ?> <br />
                                                    <?php if($row["urgency"] == "ปกติ") {?>
                                                    <a style="color: #8ebf42"><?php echo $row["urgency"]; ?></a>
                                                </td>
                                                <?php } ?>
                                                <?php if($row["urgency"] == "ด่วน") {?>
                                                <a style="color: #FE820D"><?php echo $row["urgency"]; ?></a>
                                                </td>
                                                <?php } ?>
                                                <?php if($row["urgency"] == "ด่วนที่สุด") {?>
                                                <a style="color: #E90B0B"><?php echo $row["urgency"]; ?></a>
                                                </td>
                                                <?php } ?>

                                                <td><?php echo $row["username"]; ?></td>
                                                <td><?php echo $row["tech"]; ?> <br />
                                                    <?php
                                                    if ($row["status_name"] == $status[5]){  ?>
                                                <td><a style="color: #8ebf42"><?php echo $row["status_name"]; ?></a>
                                                </td>
                                                <?php } ?>
                                                <?php
                                                    if ($row["status_name"] == $status[6]){ ?>
                                                <td><a style="color: #E90B0B"><?php echo $row["status_name"]; ?></a>
                                                </td>
                                                <?php } ?>
                                                <?php
                                                    if ($row["status_name"] == $status[1]){ ?>
                                                <td><a style="color: #8601AF"><?php echo $row["status_name"]; ?></a>
                                                </td>
                                                <?php } ?>
                                                <?php
                                                    if ($row["status_name"] == $status[2]){ ?>
                                                <td><a style="color: #0E90EA"><?php echo $row["status_name"]; ?></a>
                                                </td>
                                                <?php } ?>
                                                <?php
                                                    if ($row["status_name"] == $status[3]){ ?>
                                                <td><a style="color: #E9940B"><?php echo $row["status_name"]; ?></a>
                                                </td>
                                                <?php } ?>
                                                <?php
                                                    if ($row["status_name"] == $status[4]){ ?>
                                                <td><a style="color: #FF01A6"><?php echo $row["status_name"]; ?></a>
                                                </td>
                                                <?php } ?>

                                                <td> <button type="button" data-feather="eye" data-toggle="modal"
                                                        data-target="#exampleModalCenter<?php echo $row["case_id"]; ?>"></button>
                                                </td>
                                            </tr>
                                            <!-- Modal -->
                                            <div class="modal fade bd-example-modal-lg"
                                                id="exampleModalCenter<?php echo $row["case_id"]; ?>" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg " role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                รายละเอียดใบแจ้งซ่อม </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form id="myform1" name="form1" method="post" class="row g-3"
                                                            novalidate>
                                                            <div class="modal-body">
                                                                <div class="form-group">

                                                                    <div class="row mb-1 mt-3">
                                                                        <label for="case_id"
                                                                            class="col-sm-3 col-form-label">เลขที่ใบแจ้งซ่อม
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control" id="case_id"
                                                                                name="case_id" readonly
                                                                                value="<?php echo $row['case_id']; ?>">
                                                                        </div>
                                                                        <label for="date_end"
                                                                            class="col-sm-3 col-form-label">ช่างซ่อม
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control" id="date_end"
                                                                                name="date_end" readonly
                                                                                value="<?php echo $row['tech']; ?>">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-1 mt-2">
                                                                        <label for="date_start"
                                                                            class="col-sm-3 col-form-label">วันที่แจ้งซ่อม
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control" id="date_start"
                                                                                name="date_start" readonly
                                                                                value="<?php echo $row['date_start']; ?>">
                                                                        </div>
                                                                        <label for="date_of_operation"
                                                                            class="col-sm-3 col-form-label">วันที่ดำเนินงาน
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control"
                                                                                id="date_of_operation"
                                                                                name="date_of_operation" readonly
                                                                                value="<?php echo $row['date_operation']; ?>">
                                                                        </div>

                                                                    </div>
                                                                    <div class="row mb-1 mt-2">
                                                                        <label for="machine_no"
                                                                            class="col-sm-3 col-form-label">หมายเลขเครื่อง
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control"
                                                                                id="machine_name" name="machine_no"
                                                                                readonly
                                                                                value="<?php echo $row['machine_no']; ?>">
                                                                        </div>
                                                                        <label for="date_completion"
                                                                            class="col-sm-3 col-form-label">วันที่แล้วเสร็จ
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control"
                                                                                id="date_completion"
                                                                                name="date_completion" readonly
                                                                                value="<?php echo $row['date_completion']; ?>">
                                                                        </div>

                                                                    </div>

                                                                    <div class="row mb-1 mt-2">
                                                                        <label for="machine_name"
                                                                            class="col-sm-3 col-form-label">เครื่องมือ/เครื่องจักร
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control"
                                                                                id="machine_name" name="machine_name"
                                                                                readonly
                                                                                value="<?php echo $row['machine_name']; ?>">
                                                                        </div>
                                                                        <label for="problems_found"
                                                                            class="col-sm-3 col-form-label">ปัญหาที่พบ
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control"
                                                                                id="problems_found"
                                                                                name="problems_found" readonly
                                                                                value="<?php echo $row['problems_found']; ?>">
                                                                        </div>

                                                                    </div>

                                                                    <div class="row mb-1 mt-2">
                                                                        <label for="problem_case"
                                                                            class="col-sm-3 col-form-label">อาการเบื้องต้น
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control"
                                                                                id="problem_case" name="problem_case"
                                                                                readonly
                                                                                value="<?php echo $row['problem_case']; ?>">
                                                                        </div>
                                                                        <label for="details"
                                                                            class="col-sm-3 col-form-label">รายละเอียดการซ่อม
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control" id="details"
                                                                                name="details" readonly
                                                                                value="<?php echo $row['details']; ?>">
                                                                        </div>

                                                                    </div>

                                                                    <div class="row mb-1 mt-2">
                                                                        <label for="place_name"
                                                                            class="col-sm-3 col-form-label">สถานที่
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control" id="place_name"
                                                                                name="place_name" readonly
                                                                                value="<?php echo $row['place_name']; ?>">
                                                                        </div>
                                                                        <label for="spare_part"
                                                                            class="col-sm-3 col-form-label">อะไหล่
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <textarea class="form-control" rows="3"
                                                                                id="spare_part" name="spare_part"
                                                                                readonly><?php echo $row['spare_part']; ?></textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-1 mt-2">
                                                                        <label for="date_end"
                                                                            class="col-sm-3 col-form-label">วันที่ต้องการใช้
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control" id="date_end"
                                                                                name="date_end" readonly
                                                                                value="<?php echo $row['date_end']; ?> / <?php echo $row['urgency']; ?>">
                                                                        </div>
                                                                        <label for="note"
                                                                            class="col-sm-3 col-form-label">หมายเหตุ
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control" id="note"
                                                                                name="note" readonly
                                                                                value="<?php echo $row['note']; ?> ">
                                                                        </div>

                                                                    </div>

                                                                    <div class="row mb-1 mt-2">
                                                                        <label for="date_end"
                                                                            class="col-sm-3 col-form-label">คนแจ้งซ่อม
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control" id="date_end"
                                                                                name="date_end" readonly
                                                                                value="<?php echo $row['username']; ?> / <?php echo $row['department_name']; ?>">
                                                                        </div>
                                                                        <label for="status_name"
                                                                            class="col-sm-3 col-form-label">สถานะ
                                                                            :</label>
                                                                        <div class="col-sm-3">
                                                                            <input class="form-control" id="status_name"
                                                                                name="status_name" readonly
                                                                                value="<?php echo $row['status_name']; ?> ">
                                                                        </div>

                                                                    </div>





                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary"
                                                                    href="maintenance_view.php">close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- cdn bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script>
    feather.replace()
    </script>

    <script>
    $(document).ready(function() {
        $("#myTable").DataTable();
    });
    </script>

</body>

</html>