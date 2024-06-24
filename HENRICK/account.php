<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ACCOUNTS MANAGEMENT</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="accountcss.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
    font-family: Arial, sans-serif;
}

.container {
    margin-top: 50px;
}

.contain {
    width: 1200px; /* Change the width */
    margin: 0 auto; /* This centers the div horizontally */
}

#searchInput {
    width: 50%;
    padding: 5px; /* Add padding to all sides */
    margin: 0 auto; /* Center the search input horizontally */
    margin-left: 15%; /* Adjust the left margin */
}

.form-control.disabled-span {
    display: inline-block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
    
}

  
    </style>
</head>
<body>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <?php
  session_start();
  // Check if there is a session created using the login form
  if (isset($_SESSION['username'])) {
    echo "<h1>Welcome, " . htmlspecialchars($_SESSION['username']) . "</h1>";
    echo "<h4>Welcome, " . htmlspecialchars($_SESSION['usertype']) . "</h4>";
  } else {
    // Redirect the user to the login form
    header("location: login.php");
    exit;
  }
?>

  <script>
    $(document).ready(function () {
        // Handle add account form submission
        $('#addaccountform').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_user", true);

            $.ajax({
                type: "POST",
                url: "adduser.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);
                    } else if (res.status == 200) {
                        $('#errorMessage').addClass('d-none');
                        $('#addaccount').modal('hide');
                        $('#addaccountform')[0].reset();

                        // Reload the table
                        $('#myTable').load(location.href + " #myTable > *");
                    } else if (res.status == 500) {
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);
                    }
                }
            });
        });
    });

    // Handle edit account button click
        $(document).on('click', '.editaccount', function () {
            var username = $(this).val();

            $.ajax({
                type: "GET",
                url: "getuser.php",
                data: { username: username },
                success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        alert(res.message);
                    } else if (res.status == 200) {
                      $('#editusername_display').text(res.data.username);  // Update the span text
                      $('#editusername').val(res.data.username);  // Set the hidden input value
                        $('#editpassword').val(res.data.password);
                        // Set the selected option in the usertype dropdown based on the user's type
                        $('#editusertype').val(res.data.usertype);

                        $('#editaccounts').modal('show');
                    } else if (res.status == 500) {
                        $('#errorMessageUpdate').removeClass('d-none');
                        $('#errorMessageUpdate').text(res.message);
                    }
                }
            });
        });

        $(document).ready(function () {
        // Handle add account form submission
        $('#editaccountform').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("edit_user", true);

            $.ajax({
                type: "POST",
                url: "edituser.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 422) {
                        $('#errorMessageUpdate').removeClass('d-none');
                        $('#errorMessageUpdate').text(res.message);
                    } else if (res.status == 200) {
                        $('#errorMessageUpdate').addClass('d-none');
                        $('#editaccounts').modal('hide');
                        $('#editaccountform')[0].reset();

                        // Reload the table
                        $('#myTable').load(location.href + " #myTable > *");
                    } else if (res.status == 500) {
                        $('#errorMessageUpdate').removeClass('d-none');
                        $('#errorMessageUpdate').text(res.message);
                    }
                }
            });
        });
    });
    

          $(document).ready(function () {
          // Handle delete account button click
          $(document).on('click', '.deleteaccount', function () {
              var username = $(this).val();
              $('#deleteusername').val(username);
              $('#deleteaccount').modal('show');
          });

          // Handle delete account form submission
          $('#deleteaccountform').on('submit', function (e) {
              e.preventDefault();

              var formData = new FormData(this);
              formData.append("delete_user", true);

              $.ajax({
                  type: "POST",
                  url: "deleteuser.php",
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function (response) {
                      var res = jQuery.parseJSON(response);
                      if (res.status == 422) {
                          $('#errorMessageDelete').removeClass('d-none');
                          $('#errorMessageDelete').text(res.message);
                      } else if (res.status == 200) {
                          $('#errorMessageDelete').addClass('d-none');
                          $('#deleteaccount').modal('hide');
                          $('#deleteaccountform')[0].reset();

                          // Reload the table
                          $('#myTable').load(location.href + " #myTable > *");
                      } else if (res.status == 500) {
                          $('#errorMessageDelete').removeClass('d-none');
                          $('#errorMessageDelete').text(res.message);
                      }
                  }
              });
          });
      });

      $(document).ready(function () {
    // Handle activation account button click
    $(document).on('click', '.activateaccount', function () {
        var username = $(this).val();
        $('#activateusername').val(username); // Set the username in the form
        $('#activateaccount').modal('show'); // Show the activateaccount modal
    });

    // Handle activation account form submission
    $('#activateaccountform').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("activate_user", true);

        $.ajax({
            type: "POST",
            url: "activateuser.php", // Change to the appropriate PHP file for activating the user
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 422) {
                    $('#errorMessageActivate').removeClass('d-none');
                    $('#errorMessageActivate').text(res.message);
                } else if (res.status == 200) {
                    $('#errorMessageActivate').addClass('d-none');
                    $('#activateaccount').modal('hide');
                    $('#activateaccountform')[0].reset();

                    // Reload the table
                    $('#myTable').load(location.href + " #myTable > *");
                } else if (res.status == 500) {
                    $('#errorMessageActivate').removeClass('d-none');
                    $('#errorMessageActivate').text(res.message);
                }
            }
        });
    });
});



$(document).ready(function () {
    // Handle deactivate account button click
    $(document).on('click', '.deactivateaccount', function () {
        var username = $(this).val();
        $('#deactivateusername').val(username); // Set the username in the form
        $('#deactivateaccount').modal('show'); // Show the deactivateaccount modal
    });

    // Handle deactivate account form submission
    $('#deactivateaccountform').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("deactivate_user", true);

        $.ajax({
            type: "POST",
            url: "deactivateuser.php", // Change to the appropriate PHP file for deactivating the user
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 422) {
                    $('#errorMessageDeactivate').removeClass('d-none');
                    $('#errorMessageDeactivate').text(res.message);
                } else if (res.status == 200) {
                    $('#errorMessageDeactivate').addClass('d-none');
                    $('#deactivateaccount').modal('hide');
                    $('#deactivateaccountform')[0].reset();

                    // Reload the table
                    $('#myTable').load(location.href + " #myTable > *");
                } else if (res.status == 500) {
                    $('#errorMessageDeactivate').removeClass('d-none');
                    $('#errorMessageDeactivate').text(res.message);
                }
            }
        });
    });
});


  </script>


<script>
    $(document).ready(function () {
        // Handle search input
        $('#searchInput').on('keyup', function () {
            var searchText = $(this).val().toLowerCase();
            $('#myTable tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1)
            });
        });
    });
</script>
<!-- Add Account Modal -->
<div class="modal fade" id="addaccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add user</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addaccountform">
        <div class="modal-body">
          <div class="alert alert-warning d-none" id="errorMessage"></div>
          <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">USERNAME</label>
            <input type="text" class="form-control" id="username" name="txtusername" placeholder="Input your username">
          </div>
          <div class="mb-3">
            <label for="formGroupExampleInput2" class="form-label">PASSWORD</label>
            <input type="text" class="form-control" id="password" name="txtpassword" placeholder="Input your password">
          </div>
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="cmbusertype">
              <option selected>Select usertype</option>
              <option value="ADMINISTRATOR">ADMINISTRATOR</option>
              <option value="TECHNICAL">TECHNICAL</option>
              <option value="USER">USER</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>







<!-- Edit Account Modal -->
<div class="modal fade" id="editaccounts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit user</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editaccountform">
        <div class="modal-body">
          <div class="alert alert-warning d-none" id="errorMessageUpdate"></div>
          <div class="mb-3">
            <label for="editusername" class="form-label">USERNAME</label>
            <span class="form-control disabled-span" id="editusername_display">Sample Username</span>
            <input type="hidden" id="editusername" name="txtusername">
          </div>
          <div class="mb-3">
            <label for="editpassword" class="form-label">PASSWORD</label>
            <input type="text" class="form-control" id="editpassword" name="txtpassword" placeholder="Input your password">
          </div>
          <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="cmbusertype" id="editusertype">
              <option selected>Select usertype</option>
              <option value="ADMINISTRATOR">ADMINISTRATOR</option>
              <option value="TECHNICAL">TECHNICAL</option>
              <option value="USER">USER</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>




<!-- Delete Account Modal -->
<div class="modal fade" id="deleteaccount" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteModalLabel">Delete User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="deleteaccountform">
        <div class="modal-body">
          <div class="alert alert-warning d-none" id="errorMessageDelete"></div>
          <p>Are you sure you want to delete this user?</p>
          <input type="hidden" id="deleteusername" name="deleteusername">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- Activate Account Modal -->
<div class="modal fade" id="activateaccount" tabindex="-1" aria-labelledby="activateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="activateModalLabel">Activate User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="activateaccountform">
        <div class="modal-body">
          <div class="alert alert-warning d-none" id="errorMessageActivate"></div>
          <p>Are you sure you want to activate this user?</p>
          <input type="hidden" id="activateusername" name="activateusername">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Activate</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Deactivate Account Modal -->
<div class="modal fade" id="deactivateaccount" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deactivateModalLabel">Deactivate User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="deactivateaccountform">
        <div class="modal-body">
          <div class="alert alert-warning d-none" id="errorMessageDeactivate"></div>
          <p>Are you sure you want to deactivate this user?</p>
          <input type="hidden" id="deactivateusername" name="deactivateusername">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Deactivate</button>
        </div>
      </form>
    </div>
  </div>
</div>




<div class="contain">
  
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addaccount">
    ADD USER
  </button>
  <input type="text" id="searchInput" placeholder="Search by username">
<div class="container">
  <table id="myTable" class="table table-striped">
    <thead class="table-dark">
      <tr>
        <th>Username</th>
        <th>Pass</th>
        <th>Usertype</th>
        <th>Status</th>
        <th>Created by</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        require_once "config.php";
        $sql = "SELECT * FROM tblaccount WHERE username <> ? ORDER BY username";
        if($stmt = mysqli_prepare($link, $sql)){
          mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
          if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_array($result)){
             ?>
             <tr>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= str_repeat('*', strlen($row['password'])) ?></td>
                <td><?= htmlspecialchars($row['usertype']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td><?= htmlspecialchars($row['createdby']) ?></td>
                <td>
                    <button type="button" value="<?= htmlspecialchars($row['username']) ?>" class="editaccount btn btn-success">Edit</button>
                    <button type="button" value="<?= htmlspecialchars($row['username']) ?>" class="deleteaccount btn btn-danger">Delete</button> 
                    <button type="button" value="<?= htmlspecialchars($row['username']) ?>" class="activateaccount btn btn-primary">Active</button>
                    <button type="button" value="<?= htmlspecialchars($row['username']) ?>" class="deactivateaccount btn btn-warning">Inactive</button>
                </td>    
             </tr>
             <?php
            }
          } else {
            echo "<tr><td colspan='8'>Error executing SQL statement</td></tr>";
          }
          mysqli_stmt_close($stmt);
        } else {
          echo "<tr><td colspan='8'>Error preparing SQL statement</td></tr>";
        }
        mysqli_close($link);
      ?>
    </tbody>
  </table>
</div>
</div>
</body>
</html>
