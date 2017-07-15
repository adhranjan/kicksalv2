<?php

function bookable(){
    $return[0]='Cant Book';
    $return[1]='Can Book';
    return $return;
}


function bookingStatus(){
    $return[0]='Pending';
    $return[1]='Accepted';
    $return[2]='Rejected';
    $return[3]='Cancelled';
    return $return;
}

?>