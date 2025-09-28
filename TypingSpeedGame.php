<?php
session_start();
if (!isset($_SESSION['top'])) $_SESSION['top'] = 0;
$sentences = [
    "The quick brown fox jumps over the lazy dog.",
    "PHP is a popular scripting language.",
    "Type as fast as you can.",
    "Hello world from Typing Speed Game.",
    "GitHub Copilot helps you code faster."
];
if (!isset($_SESSION['sentence'])) $_SESSION['sentence'] = $sentences[array_rand($sentences)];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start = $_POST['start'];
    $input = $_POST['input'];
    $diff = microtime(true) - (float)$start;
    $wpm = strlen($_SESSION['sentence']) ? (str_word_count($_SESSION['sentence']) / ($diff / 60)) : 0;
    if ($input === $_SESSION['sentence'] && $wpm > $_SESSION['top']) $_SESSION['top'] = $wpm;
    $_SESSION['sentence'] = $sentences[array_rand($sentences)];
    $result = "Your speed: " . round($wpm, 2) . " WPM. Top: " . round($_SESSION['top'], 2) . " WPM.";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Typing Speed Game</title>
<style>
body { font-family: Arial; margin: 40px;}
input[type='text'] { width: 90%; font-size: 1.2em; padding: 8px;}
.sentence { font-size: 1.2em; margin-bottom: 18px;}
</style>
</head>
<body>
<h1>Typing Speed Game</h1>
<form method="post" id="form">
    <div class="sentence"><?= $_SESSION['sentence'] ?></div>
    <input type="hidden" name="start" id="start" value="<?= microtime(true) ?>">
    <input type="text" name="input" autocomplete="off" required autofocus onfocus="startTimer()">
    <button>Submit</button>
</form>
<?php if (isset($result)) echo "<h3>$result</h3>"; ?>
<script>
function startTimer() {
    document.getElementById('start').value = (new Date().getTime()/1000);
}
</script>
</body>
</html>