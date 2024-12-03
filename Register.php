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

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        echo "Registration successful!";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Register</h2>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email address</label> 
                <input type="email" class="form-control" id="email" name="email" required>
            </div> 
            <div class="form-group"> 
                <label for="password">Password</label> 
                <input type="password" class="form-control" id="password" name="password" required> 
            </div> 
            <button type="submit" class="btn btn-primary">Register</button> 
        </form> 
    </div> 
</body> 
</html>