<?php

$hotels = [

    [
        'name' => 'Hotel Belvedere',
        'description' => 'Hotel Belvedere Descrizione',
        'parking' => true,
        'vote' => 4,
        'distance_to_center' => 10.4
    ],
    [
        'name' => 'Hotel Futuro',
        'description' => 'Hotel Futuro Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 2
    ],
    [
        'name' => 'Hotel Rivamare',
        'description' => 'Hotel Rivamare Descrizione',
        'parking' => false,
        'vote' => 1,
        'distance_to_center' => 1
    ],
    [
        'name' => 'Hotel Bellavista',
        'description' => 'Hotel Bellavista Descrizione',
        'parking' => false,
        'vote' => 5,
        'distance_to_center' => 5.5
    ],
    [
        'name' => 'Hotel Milano',
        'description' => 'Hotel Milano Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 50
    ],

];

$parking_requested = false;

if(isset($_GET['parking']) && $_GET['parking'] == 'on'){
    $parking_requested = true;
    
    };

    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP-HOTEL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>

<body>
    <div class="container-fluid">
        <h1 class="text-center my-4">Lista Hotel</h1>
        <hr>
        <h2>filtri</h2>
        <form action="">

            <input type="checkbox" name="parking" id="parking">
            <label for="parking">Presenza parcheggio</label>
            <button type="submit" class="btn btn-primary btn-sm mx-2">filtra
            </button>

        </form>
        <hr class="mb-4">
    </div>

    <div class="container text-center">
        <!-- Intestazione -->
        <div class="row fw-bold border-bottom pb-2 mb-2">
            <div class="col">Nome</div>
            <div class="col">Descrizione</div>
            <div class="col">Parcheggio</div>
            <div class="col">Voto</div>
            <div class="col">Distanza</div>
        </div>

        <!-- Dati degli hotel -->
        <?php foreach ($hotels as $hotel) { 
            
        if($parking_requested && !$hotel['parking']){
            continue;
        }   
        
        ?>

            <div class="row border-bottom py-2">
                <div class="col"><?php echo $hotel['name']; ?></div>
                <div class="col"><?php echo str_replace('Descrizione', '', $hotel['description']); ?></div>
                <div class="col"><?php echo $hotel['parking'] ? 'Sì' : 'No'; ?></div>
                <div class="col"><?php echo (int) $hotel['vote']; ?></div>
                <div class="col"><?php echo number_format($hotel['distance_to_center'], 1, ',', '.'); ?> km</div>
            </div>
        <?php } ?>

    </div>

</body>

</html>