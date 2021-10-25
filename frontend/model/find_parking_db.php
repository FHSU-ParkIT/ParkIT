//functions that'll interact with database

<?php

function get_parking_availability ($start_date, $start_time){
    global $db;

    $query = '';

    $stmt = $db->prepare($query);
    $stmt->bindValue(); //bind arguments to query values
    $stmt->execute();

    $availabilities = $stmt->fetchAll();

    $stmt->closeCursor();
    
    return $availabilities;
}