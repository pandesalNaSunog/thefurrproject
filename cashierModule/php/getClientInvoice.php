<?php
    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $invoiceId = $_GET['invoice_id'];

        $query = "SELECT * FROM invoices WHERE id = '$invoiceId'";
        $invoice = $con->query($query) or die($con->error);
        $row = $invoice->fetch_assoc();

        echo json_encode($row);
    }
?>