<?php

    include 'DataBase.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Advanced validation for UoB emails
        if (!preg_match("/^[a-zA-Z0-9._%+-]+@uob\.edu\.bh$/", $email)) {
            echo "Invalid UoB email address.";
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        echo "Registration successful!";
    }
?>

