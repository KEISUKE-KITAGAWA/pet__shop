<?php 
define('DSN', 'mysql:host=db;dbname=pet_shop;charset=utf8;');
define('USER', 'staff');
define('PASSWORD', '9999');

try {
    $dbh = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $e) {
    $e->getMessage();
    exit;
}


if (empty($_GET['keyword'])) {
    $sql = 'SELECT * FROM animals';
    $stmt = $dbh->prepare($sql);
} else {
    $sql = 'SELECT * FROM animals WHERE description LIKE :keyword';
    $stmt = $dbh->prepare($sql);
    $keyword = $_GET['keyword'];
    $keyword = '%' . $keyword . '%';
    $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
}

$stmt->execute();
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ペットショップ</title>
</head>
<body>
    <div>
        <h2>本日のご紹介ペット！</h2>
        <form action="" method="get">
            <label for="" >キーワード:</label><input type="text" name="keyword" id="" value="キーワードの入力">
            <input type="submit" value="検索"><br><br>
        </form>

        <?php foreach ($animals as $animal ): ?>
        <?= $animal['type'] . 'の' . $animal['classifcation'] 
        . 'ちゃん<br>' . $animal['description'] . '<br>' . $animal['birthday'] . '生まれ<br>' 
        . '出身地' . $animal['birthplace'] . '<br><hr>'; ?>
        <?php endforeach; ?>
    </div>
    
</body>
</html>