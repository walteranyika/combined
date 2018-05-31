<?php
    require "connect.php";
    include "functions.php";
    $post = json_decode(file_get_contents("php://input"), true);
   // extract($_POST);
    $code= rand(1000,9999);
    $sql="";
    $names=$post->names;
    $phone=$post->phone;

    if ($post->type=="client")
    {
        $sql="insert into clients(names, phone, code) values ('$names','$phone','$code')";
    }else
    {
        $sql="insert into riders(names, phone, code) values ('$names','$phone','$code')";
    }
    $result = mysqli_query($conn, $sql);// or die(mysqli_errno($conn));
    if($result)
    {
        sendSMS($phone,$code);
        echo json_encode(array("status"=>"success"));
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
        sendSMS($phone,$code);
        echo json_encode(array("status"=>"success"));
    }




