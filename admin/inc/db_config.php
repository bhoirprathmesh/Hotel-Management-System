<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "hbwebsite";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $db);
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }

    function filteration($data){
        foreach($data as $key => $value){
            $data[$key] = trim($value);
            $data[$key] = stripslashes($value);
            $data[$key] = htmlspecialchars($value);
            $data[$key] = strip_tags($value); 
        }
        return $data;
    }

    function select($sql, $value, $datatypes){
        $conn = $GLOBALS['conn'];
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, $datatypes,...$value);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }else{
                die("Querry Cannot be executed ~ Select");
            }
        }else{
            mysqli_stmt_close($stmt);
            die("Querry Cannot be prepared ~ Select");
        }
    }

    function fetchDataFromDatabase($conn, $settings) {
        $data = array();
        $sql = "SELECT * FROM $settings";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function updateSettings($conn, $siteTitle, $aboutUs) {
        $siteTitle = mysqli_real_escape_string($conn, $siteTitle);
        $aboutUs = mysqli_real_escape_string($conn, $aboutUs);
    
        $sql = "UPDATE settings SET site_title='$siteTitle', site_about='$aboutUs' WHERE sr_no=1";
    
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return "Error updating settings: " . mysqli_error($conn);
        }
    }

?>

<!-- 
trim()  --remove extra whitespace
stripslashes()  --remove backslashes
htmlspecialchars() --special characters such as >, <, <=, >= etc that characters are get converted into html entities
strip_tags()  --html written on the input fields are not going to work properly 
...$values --also known as splat operator in php --here there n number of values can be send dynamically website
-->