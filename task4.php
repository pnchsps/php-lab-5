<?php
// test.php

// Инициализация
$name = '';
$q1   = '';
$q2   = [];
$q3   = '';
$errors = [];
$showResult = false;

// Обработка отправки
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $q1   = $_POST['q1'] ?? '';
    $q2   = $_POST['q2'] ?? [];
    $q3   = $_POST['q3'] ?? '';

    // Валидация
    if ($name === '') {
        $errors['name'] = 'Введите, пожалуйста, ваше имя.';
    }
    if ($q1 === '') {
        $errors['q1'] = 'Ответьте на вопрос 1.';
    }
    if (empty($q2)) {
        $errors['q2'] = 'Выберите хотя бы один вариант в вопросе 2.';
    }
    if ($q3 === '') {
        $errors['q3'] = 'Ответьте на вопрос 3.';
    }

    if (empty($errors)) {
        $showResult = true;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Онлайн-тест</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .field { margin-bottom: 12px; }
        label { display: block; font-weight: bold; }
        .error { color: #c00; font-size: 0.9em; margin-top: 4px; }
        .result { margin-top: 20px; padding: 10px; border: 1px solid #4a4; background: #efe; }
        input[type="text"] { width: 300px; padding: 6px; }
    </style>
</head>
<body>

<h1>Пройдите тест по веб-разработке</h1>

<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" novalidate>
    <div class="field">
        <label for="name">Ваше имя:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>">
        <?php if (isset($errors['name'])): ?>
            <div class="error"><?= htmlspecialchars($errors['name']) ?></div>
        <?php endif; ?>
    </div>

    <div class="field">
        <label>1. Какой язык обычно используют на сервере для динамического сайта?</label>
        <label><input type="radio" name="q1" value="PHP"    <?= $q1==='PHP'    ? 'checked' : '' ?>> PHP</label>
        <label><input type="radio" name="q1" value="HTML"   <?= $q1==='HTML'   ? 'checked' : '' ?>> HTML</label>
        <label><input type="radio" name="q1" value="JavaScript" <?= $q1==='JavaScript' ? 'checked' : '' ?>> JavaScript</label>
        <?php if (isset($errors['q1'])): ?>
            <div class="error"><?= htmlspecialchars($errors['q1']) ?></div>
        <?php endif; ?>
    </div>

    <div class="field">
        <label>2. Отметьте правильные расширения файлов PHP:</label>
        <label><input type="checkbox" name="q2[]" value=".php" <?= in_array('.php', $q2) ? 'checked' : '' ?>> .php</label>
        <label><input type="checkbox" name="q2[]" value=".html" <?= in_array('.html', $q2) ? 'checked' : '' ?>> .html</label>
        <label><input type="checkbox" name="q2[]" value=".exe" <?= in_array('.exe', $q2) ? 'checked' : '' ?>> .exe</label>
        <?php if (isset($errors['q2'])): ?>
            <div class="error"><?= htmlspecialchars($errors['q2']) ?></div>
        <?php endif; ?>
    </div>

    <div class="field">
        <label>3. Какой синтаксис обычно открывает PHP-код?</label>
        <label><input type="radio" name="q3" value="&lt;?php ?&gt;" <?= $q3==='<?php ?>' ? 'checked' : '' ?>> <code>&lt;?php ?&gt;</code></label>
        <label><input type="radio" name="q3" value="&lt;script&gt;" <?= $q3==='&lt;script&gt;' ? 'checked' : '' ?>> <code>&lt;script&gt;</code></label>
        <label><input type="radio" name="q3" value="&lt;% %&gt;" <?= $q3==='&lt;% %&gt;' ? 'checked' : '' ?>> <code>&lt;% %&gt;</code></label>
        <?php if (isset($errors['q3'])): ?>
            <div class="error"><?= htmlspecialchars($errors['q3']) ?></div>
        <?php endif; ?>
    </div>

    <button type="submit">Отправить ответы</button>
</form>

<?php if ($showResult): ?>
    <div class="result">
        <h2>Результаты теста</h2>
        <p>Имя: <?= htmlspecialchars($name) ?></p>
        <p>1. Ответ: <?= htmlspecialchars($q1) ?></p>
        <p>2. Ответы: <?= htmlspecialchars(implode(', ', $q2)) ?></p>
        <p>3. Ответ: <?= htmlspecialchars($q3) ?></p>
    </div>
<?php endif; ?>

</body>
</html>
