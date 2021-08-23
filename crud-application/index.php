<!doctype html>
<html lang="en">

<head>
    <title>PHP CRUD APPLICATION</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
</head>
<style>
    th {
        padding: 15px !important;
        vertical-align: middle !important;
    }

    td:first-of-type {
        font-weight: bolder !important;
    }

    td:first-of-type::after {
        content: ".";
    }

    td:last-of-type, th:last-of-type {
        text-align: center !important;
    }

    td {
        padding: 10px !important;
        text-align: left;
        vertical-align: middle !important;
    }
</style>
<body>

    <?php include_once "header.php"; ?>

    <div class="container-md">
        <hr>
        <h1 class="text-center font-weight-bolder">PHP CRUD APPLICATION <span class="badge bg-secondary">BY BKR</span></h1>
        <hr>
        <h3 class="text-center">ALL DATABASE RECORDS</h3>
        <center>
            <hr class="m-0" style="width:15%">
        </center>
        
        <?php 

            include_once "config.php";

            $sql = "SELECT stu_id, stu_name, stu_phone, stu_address, crs_name, crs_code FROM student AS Stu 
                    INNER JOIN course AS crs where Stu.course_id = crs_id";

            if ($result = mysqli_query($connection, $sql)) 
            {
                if(mysqli_num_rows($result) > 0) 
                {
                    echo '
                    <div class="table-responsive-md">
                        <table class="table table-bordered table-striped my-5 align-middle p-5">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>NAME</th>
                                    <th>ADDRESS</th>
                                    <th>PHONE</th>
                                    <th>COURSE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>';

                            while($row = mysqli_fetch_array($result)) {
                                echo "
                                <tr>
                                    <td>{$row['stu_id']}</td>
                                    <td>{$row['stu_name']}</td>
                                    <td>{$row['stu_address']}</td>
                                    <td>{$row['stu_phone']}</td>
                                    <td>{$row['crs_name']} ({$row['crs_code']})</td>";
                                
                                echo "<td>
                                        <button type='button' class='btn mb-2 btn-success' id='editBtn'>
                                            <a href='edit-inline.php?id={$row['stu_id']}' class='text-white text-decoration-none'>EDIT</a>
                                        </button>
                                        <button type='button' class='btn mb-2 btn-danger' id='deleteBtn'>
                                            <a href='delete-inline.php?id={$row['stu_id']}' class='text-white text-decoration-none'>DELETE</a>
                                        </button>
                                    </td>
                                </tr>";
                            };
                            echo '
                            </tbody>
                        </table>
                    </div>';
                }
                else {
                    echo "<h3 class='text-center my-4'>Nothing to Show Here. No Record is Present on Database</h3>";
                }
            }
            else {
                echo "<p>Query Unsuccessfull</p>";
            }
            
            ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
</body>

</html>