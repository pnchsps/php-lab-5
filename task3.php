<?php
// comment.php

// Инициализация переменных
$name    = '';
$mail    = '';
$comment = '';
$agree   = '';
$errors  = [];
$success = '';

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Считываем и убиреам пробелы
    $name    = trim($_POST['name']    ?? '');
    $mail    = trim($_POST['mail']    ?? '');
    $comment = trim($_POST['comment'] ?? '');
    $agree   = isset($_POST['agree']) ? $_POST['agree'] : '';

    // Валидация поля "name"
    $len = iconv_strlen($name, 'UTF-8');
    if ($name === '') {
        $errors['name'] = 'Поле «Name» обязательно.';
    } elseif ($len < 3) {
        $errors['name'] = 'Имя должно быть не менее 3 символов.';
    } elseif ($len > 20) {
        $errors['name'] = 'Имя не может быть длиннее 20 символов.';
    } elseif (preg_match('/\d/', $name)) {
        $errors['name'] = 'Имя не должно содержать цифр.';
    }

    // Валидация поля "email"
    if ($mail === '') {
        $errors['mail'] = 'Поле «Mail» обязательно.';
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors['mail'] = 'Некорректный адрес электронной почты.';
    }

    // Валидация поля "comment"
    if ($comment === '') {
        $errors['comment'] = 'Поле «Comment» обязательно.';
    }
    // Дополнительное правило: не более 500 символов
    if (iconv_strlen($comment, 'UTF-8') > 500) {
        $errors['comment'] = 'Комментарий не может быть длиннее 500 символов.';
    }

    // Проверка чекбокса
    if ($agree !== 'yes') {
        $errors['agree'] = 'Вы должны согласиться с обработкой данных.';
    }

    // Если нет ошибок — показываем сообщение об успехе
    if (empty($errors)) {
        $success = 'Спасибо! Ваш комментарий успешно отправлен.';
        $name = $mail = $comment = $agree = '';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>#my-shop — write-comment</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; }
        #container { width: 480px; margin: 40px auto; background: #fff; padding: 20px; border: 1px solid #ccc; }
        nav { margin-bottom: 10px; }
        nav a { margin-right: 8px; text-decoration: none; color: #333; }
        h1 { font-size: 1.2em; margin-bottom: 15px; }
        .field { margin-bottom: 12px; }
        label { display: block; font-weight: bold; margin-bottom: 4px; }
        input[type="text"], input[type="email"], textarea { width: 100%; padding: 6px; box-sizing: border-box; }
        .error { color: #c00; font-size: 0.9em; margin-top: 4px; }
        .success { color: #080; font-size: 1em; margin-top: 15px; }
        button { padding: 6px 12px; }
    </style>
</head>
<body>
<div id="container">
    <nav>
        <a href="#">Home</a>
        <a href="#">Comments</a>
        <a href="#">Exit</a>
    </nav>

    <h1>#write-comment</h1>

    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" novalidate>
        <div class="field">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>">
            <?php if (!empty($errors['name'])): ?>
                <div class="error"><?= htmlspecialchars($errors['name']) ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="mail">Email:</label>
            <input type="email" id="mail" name="mail" value="<?= htmlspecialchars($mail) ?>">
            <?php if (!empty($errors['mail'])): ?>
                <div class="error"><?= htmlspecialchars($errors['mail']) ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="comment">Comment:</label>
            <textarea id="comment" name="comment" rows="6"><?= htmlspecialchars($comment) ?></textarea>
            <?php if (!empty($errors['comment'])): ?>
                <div class="error"><?= htmlspecialchars($errors['comment']) ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label>
                <input type="checkbox" name="agree" value="yes" <?= $agree === 'yes' ? 'checked' : '' ?>>
                Do you agree with data processing?
            </label>
            <?php if (!empty($errors['agree'])): ?>
                <div class="error"><?= htmlspecialchars($errors['agree']) ?></div>
            <?php endif; ?>
        </div>

        <button type="submit">Send</button>
    </form>

    <?php if ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
</div>
</body>
</html>