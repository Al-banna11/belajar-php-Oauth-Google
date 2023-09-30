
<?php
    session_start();
    require 'dbcon.php';

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
    
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">

    <title>Device CRUD</title>
    <link rel="Icon" href="logo crud.png" type="image/Icon">
</head>
<style>
 
    .poppins-font {
        font-family: 'Poppins', sans-serif;
    }

    .card{
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    }

    .custom-btn {
      width: 50px;
      height: 50px; 
      margin-left: 40px;
      margin-top: 40px;
    }

    .mdi-logout{
        font-size: 20px;
    }
</style>


<body>

<div>
    <form action="logout.php" method="post">
<input type="hidden" name="logout" value="1">
<button type="submit" class="btn btn-danger custom-btn mdi mdi-logout" style="border-radius:100px;"></button>
</form>
</div>
  
    <div class="container" style="margin-top:60px;" >
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
            <div class="card ">
            <div class="card-header bg-dark text-white">
                        <h4>Device Details
                        <a href="student-create.php" class="btn btn-success float-end mdi mdi-plus">Add Device</a>
                        </h4>
                    </div>
                    <div class="card-body bg-light">

                    <table class="table table-bordered table-striped ">
    <thead class="thead-dark"> 
        <tr>
        <thead class="poppins-font">
    <tr>
        <th>UID</th>
        <th>Operator</th>
        <th>Device Name</th>
        <th>Device Type</th>
        <th>borrowing time</th>
        <th>Action</th>
    </tr>
</thead>

        </tr>
    </thead>
    <tbody>
        <?php 
            $query = "SELECT * FROM students";
            $query_run = mysqli_query($con, $query);

            if(mysqli_num_rows($query_run) > 0)
            {
                foreach($query_run as $student)
                {
                    ?>
                    <tr>
                        <td ><?= $student['uid']; ?></td>
                        <td><?= $student['name']; ?></td>
                        <td><?= $student['email']; ?></td>
                        <td><?= $student['phone']; ?></td>
                        <td><?= $student['course']; ?></td>
                        <td>
                            <a href="student-view.php?id=<?= $student['id']; ?>" class="btn btn-secondary btn-sm">
                            <i class="mdi mdi-eye"></i> 
                            </a>
                            <a href="student-edit.php?id=<?= $student['id']; ?>" class="btn btn-success btn-sm">
                            <i class="mdi mdi-pencil"></i> 
                            </a>
                            <form action="code.php" method="POST" class="d-inline">
                            <button type="submit" name="delete_student" value="<?= $student['id']; ?>" class="btn btn-danger btn-sm">
                            <i class="mdi mdi-delete"></i> 
                            </button>
                            </form>
</td>

                    </tr>
                    <?php
                }
            }
            else
            {
                echo "<tr><td colspan='6' class='text-center'>No Record Found</td></tr>";
            }
        ?>
        
    </tbody>
</table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>