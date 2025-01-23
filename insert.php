<?php

// 1. POSTデータ取得
$first = $_POST['first'];
$second = $_POST['second'];
$third = $_POST['third'];
$memo = $_POST['memo'];
$confidence_level_id = $_POST['confidence_level_id'];

// 2. DB接続します


try {
    $server_info = 'mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host;
    $pdo = new PDO($server_info, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

// 3. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, first, second, third, memo, confidence_level_id, date)
                        VALUES(NULL, :first, :second, :third, :memo, :confidence_level_id, NOW())");

// 4. バインド変数を用意
$stmt->bindValue(':first', $first, PDO::PARAM_STR);
$stmt->bindValue(':second', $second, PDO::PARAM_STR);
$stmt->bindValue(':third', $third, PDO::PARAM_STR);
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
$stmt->bindValue(':confidence_level_id', $confidence_level_id, PDO::PARAM_INT);

// 5. SQL文を実行
$status = $stmt->execute();

// 6. データ登録処理後
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('ErrorMessage:' . $error[2]);
} else {
    header('Location: select.php');
    exit();
}
?>