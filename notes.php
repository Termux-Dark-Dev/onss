<?php
session_start();
error_reporting(0);
include('user/includes/dbconnection.php');


function my_encrypt_($data, $key)
{
    $iv = openssl_random_pseudo_bytes(16); // Generate an initialization vector
    $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}


?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <title>Online Notes Sharing System | Notes</title>

    <link rel="manifest" href="site.webmanifest">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/progressbar_barfiller.css">
    <link rel="stylesheet" href="assets/css/gijgo.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/animated-headline.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include_once('includes/header.php'); ?>
    <!-- Header End -->
    <main>
        <!--? slider Area Start-->
        <section class="slider-area slider-area2">
            <div class="slider-active">
                <!-- Single Slider -->
                <div class="single-slider slider-height2">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-8 col-lg-11 col-md-12">
                                <div class="hero__caption hero__caption2">
                                    <h1 data-animation="bounceIn" data-delay="0.2s">Our Notes</h1>
                                    <!-- breadcrumb Start-->
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                            <li class="breadcrumb-item"><a href="notes.php">Notes</a></li>
                                        </ol>
                                    </nav>
                                    <!-- breadcrumb End -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Courses area start -->
        <div class="courses-area section-padding40 fix">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                            <h2>Our featured Notes</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                    if (isset($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                    } else {
                        $pageno = 1;
                    }
                    // Formula for pagination
                    $no_of_records_per_page = 10;
                    $offset = ($pageno - 1) * $no_of_records_per_page;
                    $ret = "SELECT ID FROM tblnotes";
                    $query1 = $dbh->prepare($ret);
                    $query1->execute();
                    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                    $total_rows = $query1->rowCount();
                    $total_pages = ceil($total_rows / $no_of_records_per_page);
                    $sql = "SELECT tblnotes.ID as NoteID,tblnotes.*,tbluser.* from tblnotes join tbluser on tblnotes.UserID=tbluser.ID LIMIT $offset, $no_of_records_per_page";
                    $query = $dbh->prepare($sql);

                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                        foreach ($results as $row) {               ?>
                            <div class="col-lg-6">
                                <div class="properties properties2 mb-30">
                                    <div class="properties__card">
                                        <div class="properties__img overlay1" style="position: relative;">
                                            <?php if ($row->isNotePaid == 1) : ?>
                                                <img src="https://img.icons8.com/fluency/48/money.png" style="position:absolute;top:0;right:0;z-index:999;width:48px;height:48px;object-fit:cover;" height="48px" width="48px" alt="Lock Image">
                                            <?php endif; ?>
                                            <img src="assets/img/featured2.png" style="aspect-ratio: 4/3;" alt="">
                                        </div>
                                        <div class="properties__caption">
                                            <p><?php echo htmlentities($row->Subject); ?></p>
                                            <h3><?php echo htmlentities($row->NotesTitle); ?> By (<?php echo htmlentities($row->FullName); ?>)</h3>
                                            <p><?php echo htmlentities($row->NotesDecription); ?>.

                                            </p>
                                            <div class="properties__footer d-flex justify-content-between align-items-center">
                                                <div class="restaurant-name">

                                                </div>

                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <div style="text-align: center;">
                                                    <?php $file_link = my_encrypt_($row->File, "@3shghdh%&@BBSHS@jdhjdb8262738%^(782927%782") ?>
                                                    <a <?php echo $row->isNotePaid == 0 ? "href='javascript:void(0)' onclick='downloadNote(\"" . $row->File . "\")'" : "href='javascript:void(0)' onclick='payment(" . $row->notePrice . ",\"" . $file_link . "\"," . $row->NoteID . "," . $row->UserID . ", event)'"; ?> target="_blank" class="btn bnt-primary">Download File</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <?php $cnt = $cnt + 1;
                        }
                    } ?>


                </div>
                <div align="left">
                    <ul class="pagination">
                        <li><a href="?pageno=1"><strong style="color:blue">First></strong></a></li>
                        <li class="<?php if ($pageno <= 1) {
                                        echo 'disabled';
                                    } ?>">
                            <a href="<?php if ($pageno <= 1) {
                                            echo '#';
                                        } else {
                                            echo "?pageno=" . ($pageno - 1);
                                        } ?>"><strong style="padding-left: 10px;color: blue;">Prev></strong></a>
                        </li>
                        <li class="<?php if ($pageno >= $total_pages) {
                                        echo 'disabled';
                                    } ?>">
                            <a href="<?php if ($pageno >= $total_pages) {
                                            echo '#';
                                        } else {
                                            echo "?pageno=" . ($pageno + 1);
                                        } ?>"><strong style="padding-left: 10px;color: blue;">Next></strong></a>
                        </li>
                        <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px;color: blue;">Last</strong></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Courses area End -->


    </main>

    <!-- Snackbar -->
    <div class='toast bg-danger' role='alert' aria-live='assertive' aria-atomic='true' data-delay='5000' style='position: fixed; bottom: 10; right: 20; z-index: 9999;'>
        <div class='toast-header d-flex justify-content-between'>
            <strong class='mr-auto'>Failure In Payment</strong>

        </div>
        <div class='toast-body text-light'>
            Payment Failed
        </div>
    </div>
    <?php include_once('includes/footer.php'); ?>

    <!-- JS here -->
    <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <!-- Jquery Mobile Menu -->
    <script src="./assets/js/jquery.slicknav.min.js"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="./assets/js/owl.carousel.min.js"></script>
    <script src="./assets/js/slick.min.js"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="./assets/js/wow.min.js"></script>
    <script src="./assets/js/animated.headline.js"></script>
    <script src="./assets/js/jquery.magnific-popup.js"></script>

    <!-- Date Picker -->
    <script src="./assets/js/gijgo.min.js"></script>
    <!-- Nice-select, sticky -->
    <script src="./assets/js/jquery.nice-select.min.js"></script>
    <script src="./assets/js/jquery.sticky.js"></script>
    <!-- Progress -->
    <script src="./assets/js/jquery.barfiller.js"></script>

    <!-- counter , waypoint,Hover Direction -->
    <script src="./assets/js/jquery.counterup.min.js"></script>
    <script src="./assets/js/waypoints.min.js"></script>
    <script src="./assets/js/jquery.countdown.min.js"></script>
    <script src="./assets/js/hover-direction-snake.min.js"></script>

    <!-- contact js -->
    <script src="./assets/js/contact.js"></script>
    <script src="./assets/js/jquery.form.js"></script>
    <script src="./assets/js/jquery.validate.min.js"></script>
    <script src="./assets/js/mail-script.js"></script>
    <script src="./assets/js/jquery.ajaxchimp.min.js"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="./assets/js/plugins.js"></script>
    <script src="./assets/js/main.js"></script>



    <!-- For RazorPay Payment -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        function payment(amnt, link, noteId, usrId, e) {
            var options = {
                "key": "rzp_test_VCI2z9Al9Aq8vn", // Replace with your Razorpay key
                "amount": (amnt * 100).toString(), // Amount in paise
                "currency": "INR",
                "name": "ONSS",
                "description": "Test Transaction",
                "handler": function(response) {
                    // Handle the payment response here
                    const transactionId = response.razorpay_payment_id;
                    // Create a form dynamically
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'http://localhost/onss/payment.php';

                    // Add hidden input fields for transaction ID and decrypted link
                    const transactionInput = document.createElement('input');
                    transactionInput.type = 'hidden';
                    transactionInput.name = 'transactionId';
                    transactionInput.value = transactionId;
                    form.appendChild(transactionInput);

                    const linkInput = document.createElement('input');
                    linkInput.type = 'hidden';
                    linkInput.name = 'encryptedLink';
                    linkInput.value = link;
                    form.appendChild(linkInput);

                    const noteIdInput = document.createElement('input');
                    noteIdInput.type = 'hidden';
                    noteIdInput.name = 'noteId';
                    noteIdInput.value = noteId;
                    form.appendChild(noteIdInput);

                    const noteUserInput = document.createElement('input');
                    noteUserInput.type = 'hidden';
                    noteUserInput.name = 'userId';
                    noteUserInput.value = usrId;
                    form.appendChild(noteUserInput);

                    const amntInput = document.createElement('input');
                    amntInput.type = 'hidden';
                    amntInput.name = 'amnt';
                    amntInput.value = amnt;
                    form.appendChild(amntInput);

                    // Append the form to the document and submit it
                    document.body.appendChild(form);
                    form.submit();
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
            e.preventDefault();
        }


        function downloadNote(note,e) {
            // e.preventDefault();
            const nform = document.createElement('form');
            nform.method = 'POST';
            nform.action = 'http://localhost/onss/freenote-download.php';
            const linkinpt = document.createElement('input');
            linkinpt.type = 'hidden';
            linkinpt.name = 'link';
            linkinpt.value = note;
            nform.appendChild(linkinpt);
            document.body.appendChild(nform);
            nform.submit();
            
        }
    </script>
</body>

</html>