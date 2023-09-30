<?php
require 'dbcon.php';
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

    <title>Student View</title>
    <link rel="Icon" href="logo crud.png" type="image/Icon">

    <style>
    .card {
        border: none; 
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

.card-header {
    color: #fff; 
    border-bottom: none; 
    border-top-left-radius: 10px; 
    border-top-right-radius: 10px; 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

.card-body {
    background-color: #fff; 
    border-radius: 0 0 10px 10px; 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
}

.card-title {
    font-size: 24px; 
    margin-bottom: 10px; 
}

.form-control {
    border: 1px solid #ccc; 
    border-radius: 5px;
}

.form-label {
    font-weight: bold;
}

.form-select {
    border: 1px solid #ccc; 
    border-radius: 5px; 
}

.btn-primary {
    background-color: #007bff; 
    border-color: #007bff; 
    color: #fff; 
    font-weight: bold; 
}

.btn-primary:hover {
    background-color: #0056b3; 
    border-color: #0056b3; 
}

</style>

</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header bg-dark">
                    <h4 class="card-title">Device View Details</h4>
                    <a href="index.php" class="btn btn-success float-end mdi mdi-arrow-left " style="border-radius:50px;" ></a>
                </div>
                <div class="card-body">
                    <?php
                    if(isset($_GET['id']))
                    {
                        $student_id = mysqli_real_escape_string($con, $_GET['id']);
                        $query = "SELECT * FROM students WHERE id='$student_id' ";
                        $query_run = mysqli_query($con, $query);

                        if(mysqli_num_rows($query_run) > 0)
                        {
                            $student = mysqli_fetch_array($query_run);
                            ?>

                            <div class="mb-3">
                                <label class="form-label">UID</label>
                                <p class="form-control"><?=$student['uid'];?></p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Device keeper</label>
                                <p class="form-control"><?=$student['name'];?></p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Device Name</label>
                                <p class="form-control"><?=$student['email'];?></p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Device Type</label>
                                <select name="phone" class="form-select">
                                    <option value="HP" <?=$student['phone'] == 'HP' ? 'selected' : '';?>>Handphone</option>
                                    <option value="LP" <?=$student['phone'] == 'LP' ? 'selected' : '';?>>Laptop</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">borrowing time</label>
                                <p class="form-control"><?=$student['course'];?></p>
                            </div>

                            <?php
                        }
                        else
                        {
                            echo "<h4>No Such Id Found</h4>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>