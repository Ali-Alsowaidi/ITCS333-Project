<?php include 'header.html'; ?>

<?php 

session_start();
 if (!isset($_SESSION['user_id'])) 
 {    
header("Location: Login.php");
 exit(); 
} 

include 'DataBase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $user_id = $_SESSION['user_id'];
    $room_id = $_POST['room_id']; 
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];


    // Check for booking conflicts 

    $sql = "SELECT * FROM bookings WHERE room_id = ? AND start_date = ? AND end_date = ? AND status = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$room_id, $start_date, $end_date , $status]);

    if ($stmt->rowCount() > 0) { 
    echo "This timeslot is already booked."; 
    } 
    
    else { 
    $sql = "INSERT INTO bookings (user_id, room_id, start_date, end_date, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql); 
    $stmt->execute([$user_id, $room_id, $start_date, $end_date, $status]); 
    echo "Room booked successfully!";
    } 
} 

    else { 
    $room_id = $_GET['room_id'];
 } 
 
 $sql = "SELECT * FROM rooms WHERE room_id = ?"; 
 $stmt = $pdo->prepare($sql); 
 $stmt->execute([$room_id]); 
 $room = $stmt->fetch(PDO::FETCH_ASSOC); 
 
 ?> 
 
 <main>
    <h2>Book Room</h2> 
    <form method="post" action="">
        <input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>">
        <label for="booking_date">Booking Date:</label>
        
        <input type="date" name="start_date" id="start_date" required> 
        <label for="start time">Start date:</label> 

        <input type="date" name="end_date" id="end_date" required> 
        <label for="end time">End date:</label> 
        
        <button type="submit">Book Room</button> 
        
    </form> 
    <h3><?php echo $room['room_name']; ?></h3> 
    <p>Capacity: <?php echo $room['capacity']; ?></p> 
    <p>Status: <?php echo $room['status']; ?></p> 

</main> 

<?php include 'footer.html';