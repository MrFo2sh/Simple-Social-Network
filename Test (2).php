<?php 
    $Date = time();
    $strDate=strftime("%Y-%m-%d %H:%M:%S",$Date);
    echo $strDate."<hr>";
    // sleep for 10 seconds
    $date2 =strtotime($strDate) ;
    $strDate=strftime("%Y-%m-%d %H:%M:%S",$date2);
    echo $strDate."<hr>";
    if($Date>$date2){
        echo "date1 ".strftime("%Y-%m-%d %H:%M:%S",$Date);
    }else{
        echo "date2 ".strftime("%Y-%m-%d %H:%M:%S",$date2);
    }
?>