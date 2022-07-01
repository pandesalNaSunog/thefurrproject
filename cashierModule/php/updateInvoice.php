<?php
    date_default_timezone_set('Asia/Manila');
    include('connection.php');
    $con = connect();
    $date = date('Y-m-d H:i:s');

    if(isset($_POST)){
        $invoiceId = $_POST['invoice_id'];
        $amount = $_POST['amount'];
        $change = 0;
        
        //fetch invoice
        $query = "SELECT * FROM invoices WHERE id = '$invoiceId'";
        $invoice = $con->query($query) or die($con->error);
        $invoiceRow = $invoice->fetch_assoc();
        $balance = $invoiceRow['balance'];
        //check if amount is greater than price
        $totalPrice = $invoiceRow['total_price'];
        if($amount >= $totalPrice){
            $change = $amount - $totalPrice;
        }else{
            $balance = $totalPrice - $amount;
        }
    }
?>