<?php
require '../serverLoad.php';

if (isset($_POST['docID'])) {
    $query = 'SELECT * FROM feedbacks WHERE docID = ?';
    $docID = $_POST['docID'];
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $docID);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num != 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<p>" . $row['content'] . "</p>";
    }
}
