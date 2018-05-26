<?php
if (isset($_POST["phone"]))
{
    require "connect.php";
    extract($_POST);
    $sql="";
    if ($type=="client")
    {
        $sql="select * from clients where phone='$phone' AND code='$code'";
    }else
    {
        $sql="select * from riders where phone='$phone' AND code='$code'";
    }
    $result = mysqli_query($conn, $sql);// or die(mysqli_errno($conn));
    if(mysqli_num_rows($result)==1)
    {
        if ($type=="client")
        {
            $sql="update clients set status='verified' where phone='$phone' AND code='$code'";
            mysqli_query($conn, $sql);
        }else
        {
            $sql="update riders set status='verified' where phone='$phone' AND code='$code'";
            mysqli_query($conn, $sql);
        }
        echo json_encode(array("status"=>"success"));    }
    else
    {
        echo json_encode(array("status"=>"failed"));
    }
}


