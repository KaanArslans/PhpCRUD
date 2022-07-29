<?php
require "db.php" ;
global $db;
// echo "Connected" ;

// DELETE
if ( isset($_GET["delete"])) {
    $id = $_GET["delete"] ;
    $game = getGame($id) ;
    $stmt = $db->prepare("DELETE FROM games where id = ?") ;
    $stmt->execute([$id]) ;
    $msg = "{$game["title"]} deleted" ;
}


// INSERT
if ( !empty($_POST)) {
    try {
        // var_dump($_POST) ;
        extract($_POST) ;
        $stmt = $db->prepare("INSERT INTO games (title, price, launch) VALUES (?,?,?)") ;
        $stmt->execute([$title, $price, $launch]) ;
    } catch(PDOException $ex) {
        die("insert query problem") ;
    }
}



try {
    $rs = $db->query("select * from games") ;
    $games = $rs->fetchAll(PDO::FETCH_ASSOC) ;
    // var_dump($games) ;
} catch(PDOException $ex) {
    die("select query problem") ;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game App</title>
    <link rel="stylesheet" href="app.css">
</head>
<body>
<h1>List of Games</h1>
<form action="?" method="post">
    <table>
        <tr>
            <td colspan="2">
                <input type="text" name="title" placeholder="TITLE">
            </td>
            <td>
                <input type="text" name="price" placeholder="PRICE">
            </td>
            <td>
                <input type="date" name="launch"  >
            </td>
            <td>
                <button type="submit" class="btn" name="btnSubmit">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </td>
        </tr>
        <tr>
            <th>ID</th>
            <th>TITLE</th>
            <th>PRICE</th>
            <th>LAUNCH</th>
            <th>Ops</th>
        </tr>
        <?php foreach( $games as $game) : ?>
            <tr>
                <td><?= $game["id"] ?></td>
                <td><?= $game["title"] ?></td>
                <td>$<?= $game["price"] ?></td>
                <td><?= $game["launch"] ?></td>
                <td>
                    <a href="?delete=<?= $game["id"] ?>" class="btn">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>

                    <a href="edit.php?id=<?= $game["id"] ?>" class="btn">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
        <tr>
            <td colspan="5">
                Rows: <?= count($games) ?>
            </td>
        </tr>

    </table>
</form>
<?php
if ( isset($msg)) {
    echo "<p class='msg'>$msg</p>" ;
}
?>
</body>
</html>
