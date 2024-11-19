<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['difficulty'])) {
        $difficulty = $_POST['difficulty'];

        switch ($difficulty) {
            case 'easy':
                $_SESSION['range'] = 10;
                break;
            case 'normal':
                $_SESSION['range'] = 50;
                break;
            case 'hard':
                $_SESSION['range'] = 100;
                break;
        }

        $_SESSION['target'] = rand(1, $_SESSION['range']);
        $_SESSION['attempts'] = 0;
    }

    
    if (isset($_POST['guess'])) {
        $guess = (int)$_POST['guess'];
        $_SESSION['attempts']++;

        if ($guess < $_SESSION['target']) {
            $message = "Too low! Try again.";
        } elseif ($guess > $_SESSION['target']) {
            $message = "Too high! Try again.";
        } else {
            $message = "Congratulations! You guessed the number in {$_SESSION['attempts']} attempts!";
            session_destroy();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number Guessing Game</title>
</head>
<body>
    <h1>Number Guessing Game</h1>

    <?php if (!isset($_SESSION['target'])): ?>
        <form method="post">
            <label for="difficulty">Choose Difficulty:</label>
            <select name="difficulty" id="difficulty">
                <option value="easy">Easy (1-10)</option>
                <option value="normal">Normal (1-50)</option>
                <option value="hard">Hard (1-100)</option>
            </select>
            <button type="submit">Start Game</button>
        </form>
    <?php else: ?>
        <p>Guess the number between 1 and <?= $_SESSION['range'] ?>:</p>
        <form method="post">
            <input type="number" name="guess" min="1" max="<?= $_SESSION['range'] ?>" required>
            <button type="submit">Submit Guess</button>
        </form>
    <?php endif; ?>

    <?php if (isset($message)): ?>
        <p><strong><?= $message ?></strong></p>
    <?php endif; ?>
</body>
</html>
