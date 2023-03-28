<?php
$conn = new mysqli("localhost", "root", "", "guvi2");
if (isset($_POST['susername'])) {
    $username = $_POST['susername'];
    $password = $_POST['spassword'];
 

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
 
    if ($result->num_rows > 0) {
        ?>
        <span>Username already exists.</span>
        <?php
    } elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
        ?>
        <span style="font-size:11px;">Invalid username. Space & Special Characters not allowed.</span>
        <?php
    } elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $password)) {
        ?>
        <span style="font-size:11px;">Invalid password. Space & Special Characters not allowed.</span>
        <?php
    } else {
        $mpassword = md5($password);
 
        
        $stmt = $conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $mpassword);
        $stmt->execute();
 
        ?>
        <span>Sign up Successful.</span>
        <?php
    }
}
?>