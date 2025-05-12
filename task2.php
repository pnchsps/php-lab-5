<?php
// Обработка отправки формы
$data = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем и «тримим» значения
    $data['name']       = trim($_POST['name']       ?? '');
    $data['email']      = trim($_POST['email']      ?? '');
    $data['age']        = trim($_POST['age']        ?? '');
    $data['experience'] = $_POST['experience']      ?? '';
    $data['attendance'] = $_POST['attendance']      ?? '';
    // Для чекбоксов — массив
    $data['topics']     = $_POST['topics']          ?? [];
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация на вебинар по PHP</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        fieldset { max-width: 500px; }
        .result { margin-top: 20px; padding: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>

<h1>Регистрация на вебинар по PHP</h1>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <fieldset>
        <legend>Ваши данные</legend>

        <p>
            <label>Имя:<br>
                <input type="text" name="name" value="<?php echo htmlspecialchars($data['name'] ?? ''); ?>">
            </label>
        </p>

        <p>
            <label>Email:<br>
                <input type="email" name="email" value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>">
            </label>
        </p>

        <p>
            <label>Возраст:<br>
                <input type="number" name="age" min="10" max="100" value="<?php echo htmlspecialchars($data['age'] ?? ''); ?>">
            </label>
        </p>

        <p>
            <label>Уровень подготовки:<br>
                <select name="experience">
                    <option value="">— выберите —</option>
                    <option value="beginner"    <?php if (($data['experience'] ?? '') === 'beginner')    echo 'selected'; ?>>Начальный</option>
                    <option value="intermediate"<?php if (($data['experience'] ?? '') === 'intermediate')echo 'selected'; ?>>Средний</option>
                    <option value="advanced"    <?php if (($data['experience'] ?? '') === 'advanced')    echo 'selected'; ?>>Продвинутый</option>
                </select>
            </label>
        </p>

        <p>Формат участия:</p>
        <label><input type="radio" name="attendance" value="online"
            <?php if (($data['attendance'] ?? '') === 'online') echo 'checked'; ?>> Онлайн</label>
        <label><input type="radio" name="attendance" value="offline"
            <?php if (($data['attendance'] ?? '') === 'offline') echo 'checked'; ?>> Офлайн</label>

        <fieldset style="margin-top:10px;">
            <legend>Темы, которые вас интересуют (чекбоксы)</legend>
            <label><input type="checkbox" name="topics[]" value="basics"
                <?php if (in_array('basics', $data['topics'] ?? [])) echo 'checked'; ?>> Основы PHP</label><br>
            <label><input type="checkbox" name="topics[]" value="oop"
                <?php if (in_array('oop', $data['topics'] ?? [])) echo 'checked'; ?>> ООП в PHP</label><br>
            <label><input type="checkbox" name="topics[]" value="pdo"
                <?php if (in_array('pdo', $data['topics'] ?? [])) echo 'checked'; ?>> Работа с PDO/MySQL</label>
        </fieldset>

        <p style="margin-top:10px;">
            <button type="submit">Отправить регистрацию</button>
        </p>
    </fieldset>
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <div class="result">
        <h2>Данные, полученные из формы:</h2>
        <p><strong>Имя:</strong>         <?php echo htmlspecialchars($data['name']); ?></p>
        <p><strong>Email:</strong>       <?php echo htmlspecialchars($data['email']); ?></p>
        <p><strong>Возраст:</strong>     <?php echo htmlspecialchars($data['age']); ?></p>
        <p><strong>Подготовка:</strong>  <?php echo htmlspecialchars($data['experience']); ?></p>
        <p><strong>Участие:</strong>     <?php echo htmlspecialchars($data['attendance']); ?></p>
        <p><strong>Темы интереса:</strong>
            <?php
            if (!empty($data['topics'])) {
                echo htmlspecialchars(implode(', ', $data['topics']));
            } else {
                echo 'Не выбрано';
            }
            ?>
        </p>
    </div>
<?php endif; ?>

</body>
</html>
