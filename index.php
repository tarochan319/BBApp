<?php

    $commentArray = array();
    $error_messages = array();
    $pdo = new PDO('mysql:host=localhost;dbname=xs916692_bbapp;charset=utf8', '***', '***'); 

    if (!empty($_POST["submitButton"])) {

        if (empty($_POST["username"])) {
            echo "名前を入れてください";
            $error_messages["username"] = "名前を入れてください";
        }
        
        if (empty($_POST["comment"])) {
            echo "コメントを入れてください";
            $error_messages["comment"] = "コメントを入れてください";
        }

        if (empty($error_messages)) {
            $creationDate = date('Y-m-d');

            $stmt = $pdo->prepare("INSERT INTO `bbapp_table` (`username`, `comment`, `creationDate`) VALUES (:username, :comment, :creationDate);");
            $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
            $stmt->bindParam(':comment', $_POST['comment'], PDO::PARAM_STR);
            $stmt->bindParam(':creationDate', $creationDate, PDO::PARAM_STR);

            $stmt->execute();
        }
    }

    $sql = "SELECT * FROM `bbapp_table`;";
    $commentArray = $pdo->query($sql);

    $pdo = null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板デモ</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>お筋肉の掲示板</h1>
    <div class="bbs">

        <!-- 投稿表示部分 -->
        <section class="bbs__posts">
            <?php foreach($commentArray as $comment): ?>
            <article class="bbs__post">
                <div class="bbs__post-wrapper">
                    <div class="bbs__post-header">
                        <span class="bbs__post-label">名前：</span>
                        <p class="bbs__post-username"><?php echo $comment["username"]; ?></p>
                        <time class="bbs__post-date"><?php echo $comment["creationDate"]; ?></time>
                    </div>
                    <p class="bbs__post-comment"><?php echo $comment["comment"]; ?></p>
                </div>
            </article>
            <?php endforeach; ?>
        </section>

        <!-- 入力部分 -->
        <form class="bbs__form" method="post">
            <div class="bbs__form-group">
                <input class="bbs__form-submit" type="submit" value="書き込む" name="submitButton">
                <label class="bbs__form-label">◆名前</label>
                <input class="bbs__form-input" type="text" name="username">
                <label class="bbs__form-label">◆コメント</label>
                <textarea class="bbs__form-textarea" name="comment"></textarea>
            </div>
        </form>
    </div> 
</body>

