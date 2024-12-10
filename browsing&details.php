<?php include 'header.html'; ?>

<?php

include 'Database.php';

// Fetch & display list of rooms

$sql = "SELECT * FROM rooms";
$stmt = $pdo->prepare($sql); $stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

 ?> 
 
 
 <main>

    <h2>Rooms</h2> 
    <ul> 
        <?php foreach ($rooms as $room): ?> 
            <li> 
                <h3><?php echo $room['room_name']; ?></h3> 
                <p>Capacity: <?php echo $room['capacity']; ?></p> 
                <p>Status: <?php echo $room['status']; ?></p> 
                <a href="booking.php?room_id=<?php echo $room['room_id']; ?>">Book this room</a> 
            </li> 
            <?php endforeach; ?> 
        </ul> 

</main>

<?php include 'footer.html';