<?php

    $connect=mysqli_connect("localhost","root","", "Online_voting") or die("connection failed!!");

    if($connect){

    echo "Connected";

    }

    else{
        echo "Not Connected";
    }


?>