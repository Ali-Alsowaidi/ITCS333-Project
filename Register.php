<?php

    include 'DataBase.php';

    $error_message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Advanced validation for UoB emails
        if (!preg_match("/^[a-zA-Z0-9._%+-]+@uob\.edu\.bh$/", $email)) {
            $error_message = "Invalid UoB email address.";
        } else{

            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            // Redirect to login page after successful registration 
            header("Location: login.php"); 
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url("https://unsplash.it/600/400");
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
        }
        .registration-box{
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="registration-box col-md-6">
            <h2 class="text-center">Register</h2>
            <?php if ($error_message): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error_message; ?>
                </div>
                <?php endif; ?>
            <form action="Register.php" method="post">
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
                <button type="submit" class="btn btn-primary btn-block">Register</button> 
            </form> 
            <p class="mt-3 text-center">Already registered? <a href="Login.php" class="btn btn-secondary">Login</a></p>
        </div>
    </div> 
</body> 
</html>