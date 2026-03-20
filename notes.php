<?php
$plik = "notes.txt";
$komunikat = "";
$akcja = $_POST['akcja'] ?? ''; 

if (isset($_POST['dodaj'])) {
    $tresc = trim($_POST['tresc']);
    if ($tresc === "") {
        $komunikat = "Notatka nie może być pusta!";
    } else {
        $data = date("[Y-m-d H:i:s] ");
        $linia = $data . $tresc . PHP_EOL;
        if (file_put_contents($plik, $linia, FILE_APPEND)) {
            $komunikat = "Notatka została zapisana.";
        } else {
            $komunikat = "Błąd zapisu do pliku.";
        }
    }
}

if (isset($_POST['usun'])) {
    if (file_exists($plik)) {
        if (unlink($plik)) {
            $komunikat = "Wszystkie notatki zostały usunięte.";
        } else {
            $komunikat = "Nie udało się usunąć pliku.";
        }
    } else {
        $komunikat = "Brak pliku z notatkami.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>System notatek</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>System notatek</h1>

<div class="menu">
    <form method="post" style="display:inline;">
        <input type="hidden" name="akcja" value="dodaj">
        <button type="submit">Dodaj notatkę</button>
    </form>
    <form method="post" style="display:inline;">
        <input type="hidden" name="akcja" value="wyswietl">
        <button type="submit">Wyświetl wszystkie notatki</button>
    </form>
    <form method="post" style="display:inline;">
        <input type="hidden" name="akcja" value="usun">
        <button type="submit">Usuń wszystkie notatki</button>
    </form>
</div>

<?php if ($komunikat): ?>
<p class="komunikat"><?php echo $komunikat; ?></p>
<?php endif; ?>

<div class="content">

<?php if ($akcja == 'dodaj'): ?>
    <h2>Dodaj nową notatkę</h2>
    <form method="post">
        <textarea name="tresc" rows="4"></textarea><br><br>
        <button type="submit" name="dodaj">Dodaj</button>
    </form>

<?php elseif ($akcja == 'wyswietl'): ?>
    <h2>Wszystkie notatki</h2>
    <?php
    if (!file_exists($plik) || filesize($plik) == 0) {
        echo "<p>Brak notatek.</p>";
    } else {
        $linie = file($plik);
        echo "<ol>";
        foreach ($linie as $linia) {
            echo "<li>" . htmlspecialchars($linia) . "</li>";
        }
        echo "</ol>";
    }
    ?>

<?php elseif ($akcja == 'usun'): ?>
    <h2>Usuń wszystkie notatki</h2>
    <form method="post">
        <button type="submit" name="usun">Usuń wszystkie</button>
    </form>

<?php else: ?>
    <p>Wybierz opcję z menu powyżej.</p>
<?php endif; ?>

</div> 
</div> 

</body>
</html>
