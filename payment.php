<?php
include('includes/dbconnection.php');

function my_decrypt($data, $key)
{
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $encrypted = substr($data, 16);
    return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tsc_id = $_POST["transactionId"];
    $enc_link = $_POST["encryptedLink"];
    $noteID = $_POST["noteId"];
    $usrId = $_POST["userId"];
    $amnt = $_POST["amnt"];
    $paymentstatus = "paid";
    $dec_link = my_decrypt($enc_link, "@3shghdh%&@BBSHS@jdhjdb8262738%^(782927%782");
    $pdf_link = './user/folder/' .$dec_link;
    $sql = "insert into tbltransaction(tscid,noteId,usrId,payment_status,amnt) values(:tscid,:noteid,:usrid,:paymentstatus,:amnt)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':tscid', $tsc_id, PDO::PARAM_STR);
    $query->bindParam(':noteid', $noteID, PDO::PARAM_INT);
    $query->bindParam(':usrid', $usrId, PDO::PARAM_INT);
    $query->bindParam(':paymentstatus', $paymentstatus, PDO::PARAM_STR);
    $query->bindParam(':amnt', $amnt, PDO::PARAM_STR);


    $query->execute();

    $LastInsertId = $dbh->lastInsertId();
    if ($LastInsertId != "") {
        // Set appropriate headers for download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="study.pdf"'); // Set the desired filename for download
        header('Content-length:' .filesize($pdf_link));

        // Read and output the PDF file
        readfile($pdf_link);
        exit; // Terminate further exe  
       
    } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
} else {
    // Redirect to notes.php
    header('Location: notes.php');
    exit;
}
?>