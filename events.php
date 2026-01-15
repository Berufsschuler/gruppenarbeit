<?php
session_start();

// Session prüfen
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

// DB-Verbindung
require_once("database.php");

// User aus der DB holen
$user_id = $_SESSION["user_id"];
$stmt = mysqli_prepare($conn, "SELECT username, email, `role`, profile_picture FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['username'];
    $role = $row['role'];
    $profile_picture = $row['profile_picture'];
} else {
    session_destroy();
    header("Location: login.php");
    exit();
}

$profileImage = "server_img/standard_profile_picture.jpg";
if (!empty($profile_picture) && file_exists("server_img/" . $profile_picture)) {
    $profileImage = "server_img/" . $profile_picture;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="events.css"/>
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="hname">
            <h1><c style="color: #9c8809">CCookie </c>Clicker</h1>
        </div>

        <?php if($role === 'admin'): ?>
            <a href="admin.php"><button>Admin Panel</button></a>
        <?php endif; ?>

        <a id="eventButton" href="events.php"><button>Events</button></a>
        <a id="eventButton" href="user.php"><button>My Cookie</button></a>

        <div class="login_icon_container">
            <div id="login_icon"
                 onclick="changeNav()"
                 style="background-image: url('<?= $profileImage ?>');">
            </div>
        </div>

        <div id="mySidepanel" class="sidepanel">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"></a>
            <a onclick="openExplorer()">Change Profile Picture</a>
            <a href="logout.php">Logout</a>
            <input type="file" id="fileInput" accept=".jpg,.jpeg,.png" style="display:none">
        </div>

        <script>
            function openExplorer() {
                document.getElementById("fileInput").click();
            }

            document.getElementById("fileInput").addEventListener("change", function () {
                const file = this.files[0];
                if (!file) return;
                const formData = new FormData();
                formData.append("profile_picture", file);

                fetch("upload_profile_picture.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.text())
                .then(filename => {
                    if (filename) {
                        document.getElementById("login_icon").style.backgroundImage =
                            `url('server_img/${filename}?v=${Date.now()}')`;
                    }
                });
            });

            let open = false;
            function changeNav() {
                if(open == false){
                    document.getElementById("mySidepanel").style.width = "465px";
                    open = true;
                } else {
                    document.getElementById("mySidepanel").style.width = "0px";
                    open = false;
                }
            }
        </script>
    </header>

    <!-- EVENTS CONTENT -->
    <div id="eventsContainer">
        <div class="eventCard">
            <div class="eventTitle">Cookie Baking Contest</div>
            <div class="eventDescription">
                Compete with other players to bake the most cookies in 24 hours! Top 3 winners get special rewards.
            </div>
        </div>

        <div class="eventCard">
            <div class="eventTitle">Not available at the moment</div>
            <div class="eventDescription">
                Earn double cookies from every click during the weekend. Don't miss out on this sweet bonus!
            </div>
        </div>

        <div class="eventCard">
            <div class="eventTitle">Leaderboard Challenge</div>
            <div class="eventDescription">
                Climb the leaderboard in a limited-time challenge. Top players will receive exclusive profile frames.
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <div class="footer-left">
            <div class="fname">
            <h1><c style="color: #9c8809">CCookie </c>Clicker</h1>
            </div>
            <div id="creators">Made by: Aleksandar Tesinic & Paul Heigl</div>
        </div>

        <div class="ficon">
            <div class="fpicture"></div>
        </div>

        <div class="footer-right">
            <a href="impressum.html" style="color:white">IMPRESSUM</a>
        </div>
    </footer>
</html>
