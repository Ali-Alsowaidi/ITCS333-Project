<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "booking_rooms";

try {
    $dsn = "mysql:host=$servername;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM person WHERE users = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $email = $row['Email'];
        $password = $row['password'];

    } else {
        echo "User not found!";
        exit();
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = htmlspecialchars($_POST['user_id']);
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        
        if (isset($_FILES['profile-pic']) && $_FILES['profile-pic']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $destPath = $uploadDir . basename($_FILES['profile-pic']['name']);
            
            if (move_uploaded_file($_FILES['profile-pic']['tmp_name'], $destPath)) {
                $imageName = $destPath;
            } else {
                echo "Error uploading the profile picture.";
            }
        }

       
        $updateSql = "UPDATE users SET Username = :username, Email = :email, Password = :password WHERE User_id = :user_id";
        $updateStmt = $pdo->prepare($updateSql);
        $updateData = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'user_id' => $user_id
        ];

        if ($updateStmt->execute($updateData)) {
            echo "<p>Profile updated successfully!</p>";
        } else {
            echo "<p>Error updating the profile.</p>";
        }
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Management</title>
    <link rel="stylesheet" href="style_profile.css">
</head>
<body>
    <?php
    $username = "";
    $bio = "";
    ?>
    <div class="profile-container">
        <h1>My Profile</h1>

        <div class="profile-display">
            <img src="" alt="Profile Picture" class="profile-picture">
            <h2><?php echo $username; ?></h2>
            <p><?php echo $bio; ?></p>
        </div>

        <div class="profile-edit-form">
            <h2>Edit Profile</h2>
            <form action="update_profile.php" method="post" enctype="multipart/form-data">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" value="<?php echo $username; ?>" required>

                <label for="bio">Bio:</label>
                <textarea name="bio" id="bio" rows="4"><?php echo $bio; ?></textarea>

                <label for="profile-pic">Profile Picture:</label>
                <input type="file" name="profile-pic" id="profile-pic" accept="image/*">
                <a href="logout.php" class="btn btn-danger">Logout</a>

                <button type="submit">Update Profile</button>
            </form>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars($_POST['username']);
        $bio = htmlspecialchars($_POST['bio']);

        if (isset($_FILES['profile-pic']) && $_FILES['profile-pic']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $destPath = $uploadDir . basename($_FILES['profile-pic']['name']);

            if (move_uploaded_file($_FILES['profile-pic']['tmp_name'], $destPath)) {
                echo "Profile picture uploaded successfully.";
            } else {
                echo "Error uploading the profile picture.";
            }
        }

        echo "<p>Profile updated: $username</p>";
        echo "<p>Bio: $bio</p>";
    }
    ?>
</body>
</html>
