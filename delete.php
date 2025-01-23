<?php

//1. GETデータ取得
$id = $_GET['id'];

//2. DB接続


try {
    $server_info = 'mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host;
    $pdo = new PDO($server_info, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

//3. データ削除SQL
$stmt = $pdo->prepare("DELETE FROM gs_bm_table WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

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
