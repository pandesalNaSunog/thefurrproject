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
        $fetchedAmount = $invoiceRow['amount_renderred'];

        $totalAmount = $fetchedAmount + $amount;

        //check if amount is greater than price
        $totalPrice = $invoiceRow['total_price'];
        if($totalAmount >= $totalPrice){
            $change = $totalAmount - $totalPrice;
            $balance = 0;
        }else{
            $change = 0;
            $balance = $totalPrice - $totalAmount;
        }

        $query = "UPDATE invoices SET amount_renderred = '$totalAmount', balance = '$balance', `change` = '$change', updated_at = '$date' WHERE id = '$invoiceId'";
        $con->query($query) or die($con->error);

        echo 'ok';
    }
?>