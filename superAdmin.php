<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$user = 'root';
$password = 'root';
$db = 'db_edusogno';
$host = 'localhost';
$port = 3306;

$conn = mysqli_connect($host, $user, $password, $db, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

class Event {
    public $ids;
    public $titles;
    public $descriptions;
    public $dates;
    public $hours;

    public function __construct($_ids, $_titles, $_descriptions, $_dates, $_hours) {
        $this->ids = $_ids;
        $this->titles = $_titles;
        $this->descriptions = $_descriptions;
        $this->dates = $_dates;
        $this->hours = $_hours;
    }
}
if (isset($_POST['submit'])) {

    $queryNumRows = "SELECT COUNT(*) as num_rows FROM events";
    $resultQueryNumRows = mysqli_query($conn, $queryNumRows);
    $numRows = mysqli_fetch_row($resultQueryNumRows)[0];
    
    $titles = $_POST['title'];
    $descriptions = $_POST['description'];
    $dates = $_POST['date'];
    $hours = $_POST['hour'];

    if ($numRows == 0) {
        $ids = 1;
    } else {
        $ids = $numRows + 1; 
    }

    $newEvent = new Event ($ids, $titles, $descriptions, $dates, $hours);

    $query = "INSERT INTO events (id, title, description, date, hour) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "issss" ,$newEvent->ids, $newEvent->titles, $newEvent->descriptions, $newEvent->dates, $newEvent->hours);
        mysqli_stmt_execute($stmt);
    
        header("Location: superAdmin.php");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

$queryAllEvents = "SELECT * FROM events";
$resultQueryAllEvents = mysqli_fetch_all(mysqli_query($conn, $queryAllEvents));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>EduSogno | Super Admin</title>
</head>
<body>
    <header>
    <div class="header">
            <a href="login.php"><img src="img/logo-black.svg" alt="logo"></a>
        </div>
    </header>
    <main>
        <div class="main-admin" id="appDiv">

                <div class="center-admin">
                    <h1>Ciao Super Admin</h1>
                    <h2>crea il tuo post</h2>
                   
                    <form method="post" action="" class="form" autocomplete="off">
                        <label for="title">Titolo</label>
                        <input type="text" name="title" id="title">
    
                        <label for="description">descrizione</label>
                        <input type="text" name="description" id="description">
    
                        <label for="date">Data</label>
                        <input type="date" name="date" id="date">
    
                        <label for="hour">Ora</label>
                        <input type="time" name="hour" id="hour">
    
                        
                        <button class="btn" type="submit" name="submit">Crea nuovo</button>
                    </form>
    
                </div>
                <div class="center-admin" id="center-admin2">
                    <h3>Eventi:</h3>
                    
                        <div class="center-events">
                            <?php foreach ($resultQueryAllEvents as $key => $value): ?> 
                                <div class="card">
                                    <div class="title">
                                        <p><?= $value[1]; ?></p>
                                    </div>
                                    <div class="description">
                                        <p><?= $value[2]; ?></p>
                                    </div>
                                    <div class="when">
                                        <div class="date">
                                            <p><?= $value[3]; ?></p>
                                        </div>
                                        <div class="hour">
                                            <p><?= $value[4]; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    
                </div>

        </div>
    </main>


</body>
</html>