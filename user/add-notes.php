<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ocasuid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {

        $ocasuid = $_SESSION['ocasuid'];

        $subject = $_POST['subject'];
        $notestitle = $_POST['notestitle'];
        $notesdesc = $_POST['notesdesc'];
        $file1 = $_FILES["file1"]["name"];
        $isnotepaid = isset($_POST['toggleSwitch']) ? true : false;

        $noteprice = 0;

        if($isnotepaid){
            $noteprice = $_POST["options"];
        }

        $extension1 = substr($file1, strlen($file1) - 4, strlen($file1));

        $allowed_extensions = array("docs", ".doc", ".pdf");

        if (!in_array($extension1, $allowed_extensions)) {
            echo "<script>alert('File has Invalid format. Only docs / doc/ pdf format allowed');</script>";
        } else {

            $file1 = md5($file1) . time() . $extension1;

            move_uploaded_file($_FILES["file1"]["tmp_name"], "folder/" . $file1);


            $sql = "insert into tblnotes(UserID,Subject,NotesTitle,NotesDecription,File,isNotePaid,notePrice)values(:ocasuid,:subject,:notestitle,:notesdesc,:file1,:isnotepaid,:notePrice)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':ocasuid', $ocasuid, PDO::PARAM_STR);
            $query->bindParam(':subject', $subject, PDO::PARAM_STR);
            $query->bindParam(':notestitle', $notestitle, PDO::PARAM_STR);
            $query->bindParam(':notesdesc', $notesdesc, PDO::PARAM_STR);
            $query->bindParam(':file1', $file1, PDO::PARAM_STR);
            $query->bindParam(':isnotepaid', $isnotepaid, PDO::PARAM_BOOL);
            $query->bindParam(':notePrice', $noteprice, PDO::PARAM_INT);


            $query->execute();

            $LastInsertId = $dbh->lastInsertId();
            if ($LastInsertId > 0) {
                echo '<script>alert("Notes has been added.")</script>';
                echo "<script>window.location.href ='add-notes.php'</script>";
            } else {
                echo '<script>alert("Something Went Wrong. Please try again")</script>';
            }
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- style for the toogle btn -->
        <style>
            .switch {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 34px;
            }

            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                transition: .4s;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 26px;
                width: 26px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                transition: .4s;
            }

            input:checked+.slider {
                background-color: #2196F3;
            }

            input:checked+.slider:before {
                transform: translateX(26px);
            }

            .slider.round {
                border-radius: 34px;
            }

            .slider.round:before {
                border-radius: 50%;
            }
        </style>
        <title>ONSS || Add Notes</title>

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
        <script>
            function getSubject(val) {
                //alert(val);
                $.ajax({
                    type: "POST",
                    url: "get-subject.php",
                    data: 'subid=' + val,
                    success: function(data) {
                        $("#subject").html(data);
                    }
                });
            }
        </script>
    </head>

    <body>
        <div class="container-fluid position-relative bg-white d-flex p-0">

            <?php include_once('includes/sidebar.php'); ?>


            <!-- Content Start -->
            <div class="content">
                <?php include_once('includes/header.php'); ?>


                <!-- Form Start -->
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <div class="  col-xl-6 col-sm-6">

                            <div class="bg-light rounded h-100 p-4">
                                <h6 class="mb-4">Add Notes</h6>
                                <form method="post" enctype="multipart/form-data">



                                    <br />

                                    <div class="mb-3">
                                        <label for="exampleInputEmail2" class="form-label">Notes Title</label>
                                        <input type="text" class="form-control" name="notestitle" value="" required='true'>


                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail2" class="form-label">Subject</label>
                                        <input type="text" class="form-control" name="subject" value="" required='true'>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail2" class="form-label">Notes Description</label>
                                        <textarea class="form-control" name="notesdesc" value="" required='true'></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail2" class="form-label">Upload File</label>
                                        <input type="file" class="form-control" name="file1" value="" required='true'>

                                    </div>

                                    <div style="display:flex; justify-content:space-between; margin-top:30px;">
                                        <div style="display: inline; margin-right:20px;"><span> Is Note Paid :</span></div>
                                        <label class="switch">
                                            <input type="checkbox" name="toggleSwitch">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>

                                    <br>

                                    <div id="optionField" style="display: none;">
                                        <div class="d-flex flex-row justify-content-between">
                                        <label for="options">Choose a price:</label>
                                        <select name="options" id="options" class="px-3 rounded">
                                            <option value="20">₹ 20</option>
                                            <option value="30">₹ 30</option>
                                            <option value="50">₹ 50</option>
                                        </select>
                                        </div>
                                    </div>
                                    <br>
                                    <button type="submit" name="submit" class="btn btn-primary">Add</button>
                                </form>
                            </div>
                        </div>

                        <div class="d-flex flex-column justify-content-center col-xl-6 col-sm-6">
                            <img src="https://th.bing.com/th/id/OIP.8bVgv_vYxpTPqUxRsYFSSgHaFw?rs=1&pid=ImgDetMain" alt="" srcset="">
                            <br>
                            <div style="text-align: center;">
                                <h1>Get Paid For Sharing Notes</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form End -->


                <?php include_once('includes/footer.php'); ?>
            </div>
            <!-- Content End -->


            
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/chart/chart.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/tempusdominus/js/moment.min.js"></script>
        <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>

        <!-- For Showing Options on toggling isnote paid btn -->
        <script>
            $(document).ready(function() {
                $('input[type="checkbox"]').click(function() {
                    if ($(this).prop("checked") == true) {
                        $('#optionField').show();
                    } else if ($(this).prop("checked") == false) {
                        $('#optionField').hide();
                    }
                });
            });
        </script>
    </body>

    </html><?php }  ?>