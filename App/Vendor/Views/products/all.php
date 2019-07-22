<?php
    /** HEADERS */
    header('Access-Control-Allow-Origin: *'); // public api
    header('Content-Type: application/json');
    
    
    if(count($data) > 0){
        
        // Encode $data to json & output 
        echo json_encode($data);
    }else{
        // No Products
        echo json_encode(
            array('message' => 'No products found')
        );
    }
?>