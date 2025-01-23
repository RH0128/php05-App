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

//3. データ取得SQL
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//4. データ取得
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('ErrorMessage:' . $error[2]);
} else {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>データ更新</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Zen Kaku Gothic New', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header>
        <nav class="bg-white shadow-sm">
            <div class="container mx-auto py-4">
                <div class="text-2xl font-bold text-black"><a href="index.php">有馬記念予想</a></div>
            </div>
        </nav>
    </header>
    <!-- Main -->
    <main class="container mx-auto mt-8 p-4">
        <form method="post" action="update_confirm.php" class="bg-white shadow-xl rounded px-8 py-6">
            <fieldset>
                <legend class="text-2xl mb-4">データを更新</legend>
                <input type="hidden" name="id" value="<?= htmlspecialchars($result['id']) ?>">
                <div class="mb-4">
                    <label for="first" class="block text-gray-700 text-sm font-bold mb-2">一着</label>
                    <input type="text" name="first" id="first" value="<?= htmlspecialchars($result['first']) ?>" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="second" class="block text-gray-700 text-sm font-bold mb-2">二着</label>
                    <input type="text" name="second" id="second" value="<?= htmlspecialchars($result['second']) ?>" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="third" class="block text-gray-700 text-sm font-bold mb-2">三着</label>
                    <input type="text" name="third" id="third" value="<?= htmlspecialchars($result['third']) ?>" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="memo" class="block text-gray-700 text-sm font-bold mb-2">メモ</label>
                    <textarea name="memo" id="memo" rows="4" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?= htmlspecialchars($result['memo']) ?></textarea>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">更新する 👉</button>
                    <a href="index.php" class="text-blue-500 hover:underline">戻る</a>
                </div>
            </fieldset>
        </form>
    </main>
</body>
</html>
