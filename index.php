<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 14-Jan-19
 * Time: 10:03 AM
 */

$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=colyseum", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $clients = getClients($conn);
    $showTypes = getShowTypes($conn);
    $twenty = getTwenty($conn);
    $cards = getClientsCards($conn);
    $clientsM = getClientsStartM($conn);
    $spec = getSpectacles($conn);
    $clientsAllInfos = getAllClientsInfos($conn);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

function getClients($conn)
{
$query = 'select clients.firstName, clients.lastName from clients';

    if ($query = $conn->query($query)) {
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

function getShowTypes($conn)
{
    $query = 'select showTypes.type from showTypes';

    if ($query = $conn->query($query)) {
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

function getTwenty($conn)
{
    $query = 'select clients.firstName, clients.lastName from clients limit 20';

    if ($query = $conn->query($query)) {
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

function getClientsCards($conn)
{
    $query = 'select clients.firstName, clients.lastName from clients where card = 1';

    if ($query = $conn->query($query)) {
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

function getClientsStartM($conn)
{
    $query = "select clients.firstName, clients.lastName from clients where lastName like 'M%' order by lastName ASC";
    if ($query = $conn->query($query)) {
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

function getSpectacles($conn)
{
    $query = "select shows.title, shows.performer, shows.date, shows.startTime from shows";
    if ($query = $conn->query($query)) {
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

function getAllClientsInfos($conn)
{
    $query = 'select * from clients';
    if ($query = $conn->query($query)) {
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clients</title>
</head>
<body>


<div class="container">

   <div class="clientsContainer">
       <h1>Clients:</h1>
       <?php foreach($clients as $client) { ?>
           <div class="client">
               <header><?= $client['firstName']. ' '.$client['lastName'] ?></header>
           </div>
       <?php } ?>
   </div>

    <div class="genresContainer">
        <h1>Types de shows:</h1>
        <?php foreach($showTypes as $showType) { ?>
            <div class="genre">
                <p><?= $showType['type'] ?></p>
            </div>
        <?php } ?>
    </div>

    <div class="twenty">
        <h1>20 premiers clients:</h1>
        <?php foreach($twenty as $client) { ?>
            <div class="twenty-client">
                <p><?= $client['firstName']. ' '.$client['lastName'] ?></p>
            </div>
        <?php } ?>
    </div>

    <div class="client-card">
        <h1>Clients avec carte:</h1>
        <?php foreach($cards as $client) { ?>
            <div class="client-card-item">
                <p><?= $client['firstName']. ' '.$client['lastName'] ?></p>
            </div>
        <?php } ?>
    </div>

    <div class="client-card">
        <h1>Commence par "M":</h1>
        <?php foreach($clientsM as $client) { ?>
            <p>Nom : <?= $client['lastName'] ?></p>
            <p>Prénom : <?= $client['firstName'] ?></p>
            <br>
        <?php } ?>
    </div>

    <div class="showsContainer">
        <!-- *Spectacle* par *artiste*, le *date* à *heure*. -->
        <?php foreach($spec as $show) { ?>
            <p><?= $show['title'] . ' par '. $show['performer']. ', le '.$show['date'].' à '.$show['startTime'] ?></p>
        <?php } ?>
    </div>

    <br>

    <div class="allInfos">
        <?php foreach($clientsAllInfos as $client) { ?>
            <div class="client">
                <p>Nom: <?= $client['lastName'] ?></p>
                <p>Prénom: <?= $client['firstName'] ?></p>
                <p>Date de naissance: <?= $client['birthDate'] ?></p>
                <p>Carte de fidélité: <?= $client['card'] == 1 ? 'Oui' : 'Non' ?></p>
                <?php
                if ($client['card'] == 1) { ?>
                    <p>Numéro de carte: <?= $client['cardNumber'] ?></p>
                <?php } ?>
            </div>
            <br>
        <?php } ?>
    </div>


</body>
</html>