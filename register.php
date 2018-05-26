<?php
if (isset($_POST["phone"]))
{
    require "connect.php";
    include "functions.php";
    extract($_POST);
    $code= rand(1000,9999);
    $sql="";
    if ($type=="client")
    {
        $sql="insert into clients(names, phone, code) values ('$names','$phone','$code')";
    }else
    {
        $sql="insert into riders(names, phone, code) values ('$names','$phone','$code')";
    }
    $result = mysqli_query($conn, $sql);// or die(mysqli_errno($conn));
    if($result)
    {
      echo json_encode(array("status"=>"success"));
      sendSMS($phone,$code);
    }
    else
    {
        $sql="";
        if ($type=="client")
        {
            $sql="update clients set status='unverified', code='$code' WHERE phone='$phone'";
        }
        else
        {
            $sql="update riders set status='unverified', code='$code' WHERE phone='$phone'";
        }
        mysqli_query($conn, $sql);// or die(mysqli_errno($conn));
        echo json_encode(array("status"=>"success"));
        sendSMS($phone,$code);
    }
}
else
{
    echo json_encode(array("status"=>"No data sent"));
}


