<?php
    date_default_timezone_set('Asia/Manila');
    include('connection.php');
    $con = connect();

    if(isset($_GET)){
        $query = "SELECT * FROM invoices";
        $invoice = $con->query($query) or die($con->error);
        $data = array();
        while($row = $invoice->fetch_assoc()){
            $data[] = $row;
        }
        $response = array();
        foreach($data as $dataItem){
            $createdAt = $dataItem['created_at'];
            $dateObject = date_create($createdAt);
            $formattedDate = date_format($dateObject, 'M d, Y h:i A');
            $clientId = $dataItem['client_id'];
            $query = "SELECT * FROM users WHERE id = '$clientId'";
            $client = $con->query($query) or die($con->error);
            $clientRow = $client->fetch_assoc();
            $clientName = $clientRow['name'];
            $status = "";
            if($dataItem['amount_renderred'] >= $dataItem['total_price']){
                $status = "Paid";
            }else if($dataItem['balance'] == $dataItem['total_price']){
                $status = "Unpaid";
            }else{
                $status = "Partially Paid";
            }
            
            $response[] = array(
                'client_name' => $clientName,
                'invoice_id' => $dataItem['id'],
                'date' => $formattedDate,
                'status' => $status,
                'balance' => $dataItem['balance']
            );
        }

        echo json_encode($response);
    }
?>