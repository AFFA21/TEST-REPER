<?php
include "./entete.html";
?>
<br><br>
<?php

$search = $_POST['name'];

//Connexion db
$servername = "localhost:6033";
$username2 = "root";
$password2 = "root";
$dbname = "db_inde";

$db = new PDO("mysql:host=$servername;dbname=$dbname", $username2, $password2);

// Définir le mode d'erreur PDO sur exception
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$idInformation=[];
$rating =[];
$compagny = [];
$job = [];
$salary =[];
$salaryFranc =[];
$salaries=[];
$location=[];
$imageName=[];
$searchParam = "%$search%"; // Ajout des pourcentages pour la recherche partielle

$sql = "SELECT idInformation, infRating, infCompagnyName, infJobTitle, infSalary, infSalaryFranc, infSalariesReported, infSalariesReported, infLocation, infImage  FROM t_information WHERE infJobTitle LIKE :search ORDER BY infSalary DESC;";

$stmt = $db->prepare($sql);
$stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
$stmt->execute();

$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($resultats as $row) {
    $idInformation[] = $row["idInformation"];
    $rating []= $row["infRating"];
    $compagny [] = $row["infCompagnyName"];
    $job [] =  $row["infJobTitle"];
    $salary[]= $row["infSalary"];
    $salaryFranc[]= $row["infSalaryFranc"];
    $salaries[]= $row["infSalariesReported"];
    $location[]= $row["infLocation"];
    $imageName[]= $row["infImage"];
}
if (!empty($idInformation)){
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <html data-theme="retro">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.20/dist/full.min.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            color: #6b6b6b;
        }
        td {
            border: 1px solid #383737; /* Bordure des cellules */
            text-align: center;
        }
        thead th{
            font-size: 20px;
            text-align: center;
            color: #4f4e4e;
            top: 8px;
        }
    </style>
</head>
<body>
<div class="overflow-x-auto">
    <table class="table table-xs table-pin-rows table-pin-cols ;">
        <thead>
        <tr>
            <th>Notation</th>
            <th>Nom de la compagnie</th>
            <th>Salaire en roupies</th>
            <th>Salaire en Francs</th>
            <th>Localisation</th>
            <th>Titre d'emploi</th>
            <th>Images d'illustration </th>
        </tr>
        </thead>

        <?php
        // Utiliser une boucle pour générer les lignes du tableau
        for ($i = 0; $i < sizeof($idInformation); $i++) {
            ?>

            <tr>
                <td><?php echo $rating[$i]; ?></td>
                <td><?php echo $compagny[$i]; ?></td>
                <td><?php echo "$salary[$i] ₹"; ?></td>
                <td><?php echo "$salaryFranc[$i] fr. - ($salary[$i] ₹)"; ?></td>
                <td><?php echo $location[$i]; ?></td>
                <td><?php echo $job[$i]; ?></td>
                <td><img src="images/<?=$imageName[$i]?>"/></td>

            </tr>
            <?php
        }
        ?>

    </table>

</div>
</body>
</html>
<?php
}
else { ?>
    <html>
    <html data-theme="retro">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.20/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    body {
        display: flex;
        align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }
    </style>
    <div class="card w-2/7 bg-base-100 shadow-xl bg-slate-100">
        <div class="card-body">
            <div role="alert" class="alert alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>Erreur! Il n'y a pas de données de ce type</span>
            </div>
    <?php
}
