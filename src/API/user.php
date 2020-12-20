<?php
    if(isset($_POST["id"]))  {
        // Update or Delete   
        $id = $_POST["id"];

        if(!isset($_POST["username"])) {
            $sql = "DELETE FROM Post WHERE id='$id'";
        } else {
            $username = $_POST["username"];
            $password = $_POST["rePassword"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            $address = $_POST["address"];

            $sql = "UPDATE User SET username='$username', password='$password', phone='$phone', email='$email', address='$address' WHERE id='$id'";
        }

        include 'db_connection.php';
        $conn = OpenCon();
        if(mysqli_query($conn, $sql)){
            echo json_encode(['code'=>200, 'msg'=>"success."]);
        } else{
            echo json_encode(['code'=>500, 'msg'=>"ERROR: Could not able to execute $sql. " . mysqli_error($conn)]);
        }
        CloseCon($conn);
    
    } 
    // else if(isset($_POST["user_id"])) { 
    //     // Create
    //     $user_id = $_POST["user_id"];
    //     $title = $_POST["title"];
    //     $message = $_POST["message"];

    //     include 'db_connection.php';
    //     $conn = OpenCon();
 
    //     $sql = "INSERT INTO Post (user_id, title, message) VALUES ('$user_id', '$title', '$message')";
        
    //     if(mysqli_query($conn, $sql)){
    //         echo json_encode(['code'=>200, 'msg'=>"success."]);
    //     } else{
    //         echo json_encode(['code'=>500, 'msg'=>"ERROR: Could not able to execute $sql. " . mysqli_error($conn)]);
    //     }

    //     CloseCon($conn);
    // }
    else 
    { 
        // getListPost
        $id = $_GET["id"];
           
        $sql = "SELECT * FROM User WHERE id='$id'";
           
        include 'db_connection.php';
        $conn = OpenCon();
        $result = $conn->query($sql);
    
        $return = $result->fetch_all(MYSQLI_ASSOC);
    
    
        echo json_encode($return);
        CloseCon($conn);
    }
?>