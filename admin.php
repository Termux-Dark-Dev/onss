<?php
include_once('includes/dbconnection.php');
session_start();
if (!isset($_SESSION['verified'])) {
  header("Location: index.php");
}

if (isset($_POST['tscid'])) {
  $tscid = $_POST['tscid'];

  $sql = "UPDATE tbltransaction SET admin_paid=1 WHERE tscid=:tscid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':tscid', $tscid, PDO::PARAM_STR);
  $query->execute();

  exit("Payment status updated successfully.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
  <div class="container p-2 lg-12 d-flex justify-content-center">
    <h1>Payment Stats</h1>
  </div>

  <div style="padding: 10px;">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Transaction ID</th>
          <th scope="col">Created User Name</th>
          <th scope="col">Amount</th>
          <th scope="col">Upi Id</th>
          <th scope="col">Paid To User</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT tbltransaction.tscid,tbltransaction.amnt,tbltransaction.admin_paid,tbluser.acc_detail,tbluser.FullName FROM tbltransaction inner join tbluser on tbltransaction.usrId=tbluser.ID";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($results as $key => $value) {

          echo "<tr>";
          echo "<td>" . $value->tscid . "</td>";
          echo "<td>" . $value->FullName . "</td>";
          echo "<td>" . $value->amnt . "</td>";
          echo "<td>" . $value->acc_detail . "</td>";
          echo "<td>";
          if ($value->admin_paid == 1) {
            echo "<center><button style='width:100px;' type='button' class='btn btn-success'>Paid</button></center>";
          } else {
            echo "<center><button style='width:100px;' type='button' class='btn btn-danger' onclick='pay(\"$value->tscid\")'>Pay</button></center>";
          }
          echo "</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    function pay(tscid) {
      $.ajax({
        url: window.location.href, // Current page URL
        type: 'post',
        data: {
          tscid: tscid
        },
        success: function(response) {
          location.reload(); // Reload the page to see the updated status
        }
      });
    }
  </script>

</body>

</html>