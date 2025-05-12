<?php
// Инициализация переменных
$name    = $email = $review = $comment = "";
$errors  = [];

// Обработка отправки формы
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // «Тримим» входные данные
    $name    = trim($_POST["name"]    ?? "");
    $email   = trim($_POST["email"]   ?? "");
    $review  = $_POST["review"]       ?? "";
    $comment = trim($_POST["comment"] ?? "");

    // Валидация
    if ($name === "") {
        $errors['name'] = "Пожалуйста, укажите имя.";
    }
    if ($email === "") {
        $errors['email'] = "Пожалуйста, укажите email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Неверный формат email.";
    }
    if ($review === "") {
        $errors['review'] = "Пожалуйста, выберите оценку.";
    }
    if ($comment === "") {
        $errors['comment'] = "Пожалуйста, оставьте комментарий.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оставьте отзыв</title>
    <style>
        .errors { color: red; }
        .errors ul { margin: 0; padding-left: 20px; }
    </style>
</head>
<body>
<div class="form">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <fieldset>
            <legend>Оставьте отзыв!</legend>
            <div id="main_info" style="display: flex; flex-direction: column; gap: 10px;">
                <div>
                    <label>Имя:
                        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"/>
                    </label>
                </div>
                <div>
                    <label>Email:
                        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"/>
                    </label>
                </div>
            </div>
            <div id="extra_info">
                <p>Оцените наш сервис:</p>
                <div style="display: flex; flex-direction: column;">
                    <label><input type="radio" name="review" value="10"
                        <?php if ($review === "10") echo "checked"; ?>> Хорошо</label>
                    <label><input type="radio" name="review" value="8"
                        <?php if ($review === "8")  echo "checked"; ?>> Удовлетворительно</label>
                    <label><input type="radio" name="review" value="5"
                        <?php if ($review === "5")  echo "checked"; ?>> Плохо</label>
                </div>
            </div>
            <div id="message_info">
                <p>Ваш комментарий:</p>
                <textarea name="comment" cols="30" rows="10"><?php echo htmlspecialchars($comment); ?></textarea>
            </div>
            <div id="buttons" style="display: flex; gap: 10px; margin-top: 10px;">
                <input type="submit" value="Отправить"/>
                <input type="reset" value="Удалить"/>
            </div>
        </fieldset>
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?php echo htmlspecialchars($e); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <div id="result">
                <p>Ваше имя: <b><?php echo htmlspecialchars($name); ?></b></p>
                <p>Ваш e-mail: <b><?php echo htmlspecialchars($email); ?></b></p>
                <p>Оценка сервиса: <b><?php echo htmlspecialchars($review); ?></b></p>
                <p>Ваше сообщение: <b><?php echo htmlspecialchars($comment); ?></b></p>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>
</body>
</html>