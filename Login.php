<?php
    include 'DataBase.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT password FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password, $result['password'])) {
            echo "Login successful!";
        } else {
            echo "Invalid email or password.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style> 
        body { 
            background-image: url('https://unsplash.it/600/400'); 
            background-size: cover; 
            background-position: center; 
            height: 100vh; 
            margin: 0;
        } 
        .login-box { 
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
        <div class="login-box col-md-6">
            <h2 class="text-center">Login</h2>
            <form action="Login.php" method="post">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            <p class="mt-3 text-center">Don't have an account? <a href="Register.php" class="btn btn-secondary">Register</a></p>
        </div>
    </div>
</body>
</html>
