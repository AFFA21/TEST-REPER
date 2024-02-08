<?php
include "./entete.html";
?>
<br><br>
<?php

$servername = "localhost:6033";
$username2 = "root";
$password2 = "root";
$dbname = "db_inde";
$db = new mysqli($servername, $username2, $password2, $dbname);


    $sql = "SELECT idInformation, infRating, infCompagnyName, infJobTitle, infSalary, infSalaryFranc, infSalariesReported, infSalariesReported, infLocation, infImage  FROM t_information WHERE infJobTitle LIKE :search ORDER BY infSalary DESC;";

//CONNECTION DB
$sql = "SELECT idInformation, infRating, infCompagnyName, infJobTitle, infSalary, infSalaryFranc, infSalariesReported, infSalariesReported, infLocation, infImage  FROM t_information ORDER BY infSalary DESC;";
$result = $db->query($sql);


//CREER LES LISTES POUR Y INSERE LES INFORMATIONS
$idInformation=[];
$rating =[];
$compagny = [];
$job = [];
$salary =[];
$salaryFranc =[];
$salaries=[];
$location=[];
$imageName=[];

//INSERER LES INFORMATION DANS LE LISTES
while ($row = $result->fetch_assoc()) {

    $idInformation[]=$row["idInformation"];
    $rating[] = $row["infRating"];
    $compagny[] =$row["infCompagnyName"];
    $job[] =$row["infJobTitle"];
    $salary[] = $row["infSalary"];
    $salaryFranc[] = $row["infSalaryFranc"];
    $salaries[]= $row["infSalariesReported"];
    $location[]= $row["infLocation"];
    $imageName[]= $row["infImage"];
}
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
