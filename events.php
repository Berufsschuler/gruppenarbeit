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

// Events aus DB laden
$stmt = mysqli_prepare($conn, "SELECT id, title, description, is_active FROM events ORDER BY id ASC");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$events = [];
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Events</title>
<link rel="stylesheet" href="events.css"/>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap" rel="stylesheet"/>
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
    <?php foreach($events as $event): ?>
        <div class="eventCard">
            <div class="eventTitle">
                <?= htmlspecialchars($event['title']) ?> - 
                <span style="color: <?= $event['is_active'] ? 'green' : 'red' ?>">
                    <?= $event['is_active'] ? 'Active' : 'Not available' ?>
                </span>
            </div>
            <div class="eventDescription">
                <?= htmlspecialchars($event['description']) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- FOOTER -->
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

</body>
</html>
