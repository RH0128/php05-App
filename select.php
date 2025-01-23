<?php

//関数をfuncs.phpから呼び出す
require_once('funcs.php');

//1. DB接続します


try {
    $server_info = 'mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host;
    $pdo = new PDO($server_info, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

//２．データ取得SQL作成
$sql = "SELECT
          gs_bm_table.*,
          gs_confidencelevels_table.level
        FROM
          gs_bm_table
        JOIN
          gs_confidencelevels_table
        ON gs_bm_table.confidence_level_id = gs_confidencelevels_table.id;";
$stmt = $pdo->prepare($sql); //なくても良さそう
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<div class="p-4 mb-4 bg-white rounded-lg shadow-md">';
        $view .= '<p>一着: ' . htmlspecialchars($result['first']) . '</p>';
        $view .= '<p>二着: ' . htmlspecialchars($result['second']) . '</p>';
        $view .= '<p>三着: ' . htmlspecialchars($result['third']) . '</p>';
        $view .= '<p>メモ: ' . htmlspecialchars($result['memo']) . '</p>';
        $view .= '<p>自信レベル: ' . htmlspecialchars($result['level']) . '</p>';
        $view .= '<p class="text-gray-600">予想日: ' . htmlspecialchars($result['date']) . '</p>';
        $view .= '<a href="delete.php?id=' . $result['id'] . '" class="text-red-500 hover:underline">削除</a> ';
        $view .= '<a href="update.php?id=' . $result['id'] . '" class="text-blue-500 hover:underline">更新</a>';
        $view .= '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>競馬予想表示</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Zen Kaku Gothic New', sans-serif;
    }
</style>
</head>
<body class="bg-gray-100">
<!-- Head[Start] -->
<header>
  <nav class="bg-white shadow-xl">
    <div class="container mx-auto py-4">
      <div class="flex justify-between items-center">
        <div class="text-2xl font-bold text-black"><a href="index.php">予想登録</a></div>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<main class="container mx-auto mt-8 p-4">
  <div class="grid gap-4">
    <?= $view ?>
      <!-- もう一度予想するボタン -->
    <div class="flex justify-center mt-8">
      <a href="index.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        👈 もう一度予想する
      </a>
    </div>

  </div>
</main>
<!-- Main[End] -->

</body>
</html>