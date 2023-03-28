<?php 
$conn= new mysqli("localhost","root","","guvi2");
$redis=new Redis();
$redis->connect('127.0.0.1',6379);
$redis->set('loginInfo', json_encode(array('username' => $_POST['username'], 'password' => $_POST['password'])));
    
session_start();
if(isset($_POST['username'])){
    $username=$_POST['username'];
    $password=md5($_POST['password']);
 
    // Prepare the select query
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
 
    if ($result->num_rows > 0) {
        $row = $result->fetch_array();
        $_SESSION['user'] = $row['userid'];
    } else {
        ?>
        <?php
    }
}
?>