<?php
    if(isset($_POST["id"]))  {
        // Update or Delete   
        $id = $_POST["id"];

        if(!isset($_POST["title"])) {
            $sql = "DELETE FROM Post WHERE id='$id'";
        } else {
            $user_id = $_POST["user_id"];
            $title = $_POST["title"];
            $message = $_POST["message"];

            $sql = "UPDATE Post SET title='$title', message='$message' WHERE id='$id'";
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
    else if(isset($_POST["user_id"])) { 
        // Create
        $user_id = $_POST["user_id"];
        $title = $_POST["title"];
        $message = $_POST["message"];

        include 'db_connection.php';
        $conn = OpenCon();
 
        $sql = "INSERT INTO Post (user_id, title, message) VALUES ('$user_id', '$title', '$message')";
        
        if(mysqli_query($conn, $sql)){
            echo json_encode(['code'=>200, 'msg'=>"success."]);
        } else{
            echo json_encode(['code'=>500, 'msg'=>"ERROR: Could not able to execute $sql. " . mysqli_error($conn)]);
        }

        CloseCon($conn);
    }
    else { 
        // getListPost
        $user_id = $_GET["user_id"];
           
        $sql = "SELECT * FROM Post WHERE user_id='$user_id'";
           
        include 'db_connection.php';
        $conn = OpenCon();
        $result = $conn->query($sql);
    
        $return = $result->fetch_all(MYSQLI_ASSOC);
    
    
        echo json_encode($return);
        CloseCon($conn);
    }
?>