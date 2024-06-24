<?php
// Include the config file
require_once "config.php";

// Check if a username is provided
if (isset($_GET['username'])) {
    // Prepare and execute the SQL statement to retrieve user data
    $sql = "SELECT * FROM tblaccount WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $_GET['username']);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            // Return the user data as JSON
            echo json_encode($row);
        } else {
            echo "Error executing SQL statement";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing SQL statement";
    }
    mysqli_close($link);
} else {
    echo "Username not provided";
}
?>
