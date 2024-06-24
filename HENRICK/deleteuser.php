<?php
include("session-checker.php");
require_once "config.php";

// Delete an existing user
if (isset($_POST['delete_user'])) {
    $username = mysqli_real_escape_string($link, $_POST['deleteusername']); // Correcting the parameter name

    // Delete account
    $query = "DELETE FROM tblaccount WHERE username = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);

    if (mysqli_stmt_execute($stmt)) {
        $res = [
            'status' => 200,
            'message' => 'Account deleted successfully'
        ];
    } else {
        $res = [
            'status' => 500,
            'message' => 'Failed to delete user'
        ];
    }

    echo json_encode($res);
    mysqli_stmt_close($stmt);
}
?>
