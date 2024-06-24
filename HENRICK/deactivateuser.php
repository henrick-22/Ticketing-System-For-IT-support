<?php
include("session-checker.php");
require_once "config.php";

// Deactivate an existing user
if (isset($_POST['deactivate_user'])) {
    $username = mysqli_real_escape_string($link, $_POST['deactivateusername']);

    // Check if username exists
    $check_query = "SELECT * FROM tblaccount WHERE username = ?";
    $stmt = mysqli_prepare($link, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 0) {
        $res = [
            'status' => 422,
            'message' => 'Username does not exist'
        ];
        echo json_encode($res);
        mysqli_stmt_close($stmt);
        return;
    }

    mysqli_stmt_close($stmt);

    // Update account status to INACTIVE
    $query = "UPDATE tblaccount SET status = 'INACTIVE' WHERE username = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);

    if (mysqli_stmt_execute($stmt)) {
        $res = [
            'status' => 200,
            'message' => 'Account deactivated successfully'
        ];
    } else {
        $res = [
            'status' => 500,
            'message' => 'Failed to deactivate user'
        ];
    }

    echo json_encode($res);
    mysqli_stmt_close($stmt);
    return;
}
?>
