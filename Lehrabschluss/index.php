<!DOCTYPE html>
<?php 
include 'Classes/DatabaseHandler.classes.php';
?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tabellenselektor</title>
    <meta name="description" content="Select tables from the database">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

<?php
function renderOptions($tableNames) {
    foreach ($tableNames as $tableName) {
        echo '<option value="' . htmlspecialchars($tableName) . '">' . htmlspecialchars($tableName) . '</option>';
    }
}

function renderForm($result) {
    $entityCounter = 1;
    foreach ($result as $row) {
        echo '<p><strong>Eintrag: ' . $entityCounter . '</strong></p>';
        echo '<div class="container">';
        foreach ($row as $field => $value) {
            echo '<div class="col-md-6">';
            echo '<div class="form-group">';
            echo '<label for="' . htmlspecialchars($field) . '">' . htmlspecialchars($field) . '</label>';
            echo '<input type="text" class="form-control" id="' . htmlspecialchars($field) . '" name="' . htmlspecialchars($field) . '" value="' . htmlspecialchars($value) . '">';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '<hr>'; // Separator between each row's data
        $entityCounter++;
    }
}
?>

<div class="container">
    <h1>Tabellenselektor</h1>

    <!-- DB für alle Table Names ansprechen -->
    <form action="" method="GET">
        <div class="form-group">
            <label for="tablenames">Tabellennamen</label><br>
            <select class="form-control" name="tablenames" id="tablenames">
                <?php
                $db = new DatabaseHandler();                    
                $tableNames = $db->getTableNames();
                renderOptions($tableNames);
                ?>
            </select><br>
            <button type="submit" class="btn btn-primary">Auswählen</button>
        </div>
    </form>
</div>

<div class="container">
    <h1>Ergebnis</h1>

    <!-- DB für alle Table Names ansprechen -->
    <form action="" method="POST">
        <div class="form-group">
            <label for="tablenames2"><?php $tableName = htmlspecialchars($_GET["tablenames"]); echo $tableName; ?></label><br>
            <?php
            $result = $db->fetchTableNameData($tableName);
            renderForm($result);
            ?>
        </div>
    </form>
</div>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
