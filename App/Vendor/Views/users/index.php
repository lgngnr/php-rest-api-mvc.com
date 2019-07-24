<?php
    /** HEADERS */
    header('Access-Control-Allow-Origin: *'); // public api
    header('Content-Type: application/json');
    
    
    if($data){
        
        // Encode $data to json & output 
        echo json_encode($data);
    }else{
        // No Products
        echo json_encode(
            array('message' => 'No data retrieved')
        );
    }
?>