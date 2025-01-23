<?php

//1. POSTデータ取得
$id = $_POST['id'];
$first = $_POST['first'];
$second = $_POST['second'];
$third = $_POST['third'];
$memo = $_POST['memo'];

//2. DB接続

try {
    $server_info = 'mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host;
    $pdo = new PDO($server_info, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

//3. データ更新SQL
$stmt = $pdo->prepare("UPDATE gs_bm_table SET first = :first, second = :second, third = :third, memo = :memo WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':first', $first, PDO::PARAM_STR);
$stmt->bindValue(':second', $second, PDO::PARAM_STR);
$stmt->bindValue(':third', $third, PDO::PARAM_STR);
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);

//4. 実行
$status = $stmt->execute();

//5. 処理後
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('ErrorMessage:' . $error[2]);
} else {
    header('Location: select.php');
    exit();
}
?>
