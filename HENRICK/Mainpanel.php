<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        /* Some basic CSS for styling the navigation bar */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #333;
            color: #fff;
            padding: 10px;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 10px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <!-- Navigation links -->
            <?php
            // Define your navigation links as an associative array with link text as keys and URLs as values
            $navLinks = array(
                "Dashboard" => "dashboard.php",
                "Users" => "users.php",
                "Products" => "products.php",
                "Settings" => "settings.php"
            );

            // Loop through the array to generate the navigation links dynamically
            foreach ($navLinks as $text => $url) {
                echo "<li><a href=\"$url\">$text</a></li>";
            }
            ?>
        </ul>
    </nav>
</body>
</html>
