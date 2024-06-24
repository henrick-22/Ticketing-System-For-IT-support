<?php
include("session-checker.php");
require_once "config.php";


// Add a new user
if (isset($_POST['save_user'])) {
    $username = mysqli_real_escape_string($link, $_POST['txtusername']);
    $password = mysqli_real_escape_string($link, $_POST['txtpassword']);
    $usertype = mysqli_real_escape_string($link, $_POST['cmbusertype']);
    $createdBy = $_SESSION['username'];

    // Validate fields
    if (empty($username) || empty($password) || empty($usertype) || $usertype == 'Select usertype') {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    // Check if username already exists
    $check_query = "SELECT * FROM tblaccount WHERE username = ?";
    $stmt = mysqli_prepare($link, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $res = [
            'status' => 422,
            'message' => 'Username already exists'
        ];
        echo json_encode($res);
        mysqli_stmt_close($stmt);
        return;
    }


    // Check for special characters in username
    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        $res = [
            'status' => 422,
            'message' => 'Username can only contain letters and numbers'
        ];
        echo json_encode($res);
        return;
    }
    mysqli_stmt_close($stmt);

    // Insert new account
    $query = "INSERT INTO tblaccount (username, password, usertype, status, createdby) VALUES (?, ?, ?, 'ACTIVE', ?)";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $password, $usertype, $createdBy);

    if (mysqli_stmt_execute($stmt)) {
        $res = [
            'status' => 200,
            'message' => 'Account added successfully'
        ];
    } else {
        $res = [
            'status' => 500,
            'message' => 'Failed to add user'
        ];
    }

    echo json_encode($res);
    mysqli_stmt_close($stmt);
    return;
}

?>