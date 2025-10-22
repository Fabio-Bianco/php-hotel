<?php

$hotels = [
    [
        'name' => 'Hotel Belvedere',
        'description' => 'Elegante hotel con vista panoramica e servizi di lusso nel cuore della città',
        'parking' => true,
        'vote' => 4,
        'distance_to_center' => 10.4,
        'price' => 120,
        'image' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=400&h=250&fit=crop'
    ],
    [
        'name' => 'Hotel Futuro',
        'description' => 'Hotel moderno e tecnologico con design contemporaneo e comfort innovativi',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 2,
        'price' => 85,
        'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=400&h=250&fit=crop'
    ],
    [
        'name' => 'Hotel Rivamare',
        'description' => 'Incantevole struttura fronte mare con atmosfera rilassante e vista oceanica',
        'parking' => false,
        'vote' => 1,
        'distance_to_center' => 1,
        'price' => 65,
        'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=400&h=250&fit=crop'
    ],
    [
        'name' => 'Hotel Bellavista',
        'description' => 'Hotel boutique di charme con servizio personalizzato e atmosfera esclusiva',
        'parking' => false,
        'vote' => 5,
        'distance_to_center' => 5.5,
        'price' => 200,
        'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=400&h=250&fit=crop'
    ],
    [
        'name' => 'Hotel Milano',
        'description' => 'Hotel business nel centro finanziario, ideale per viaggi di lavoro e meeting',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 50,
        'price' => 95,
        'image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=400&h=250&fit=crop'
    ],
];

// Filtri avanzati con UX migliorata
$parking_requested = isset($_GET['parking']) && $_GET['parking'] == 'on';
$min_vote = isset($_GET['minimum_vote']) && is_numeric($_GET['minimum_vote']) ? (int)$_GET['minimum_vote'] : 0;

// Logica di filtro migliorata
$filteredHotels = array_filter($hotels, function($hotel) use ($parking_requested, $min_vote) {
    $passParking = !$parking_requested || $hotel['parking'];
    $passVote = $hotel['vote'] >= $min_vote;
    return $passParking && $passVote;
});

// Funzione per generare stelle
function generateStars($rating) {
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $stars .= '<i class="star-filled">★</i>';
        } else {
            $stars .= '<i class="star-empty">☆</i>';
        }
    }
    return $stars;
}

?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Trova e confronta i migliori hotel con filtri avanzati">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <title>🏨 HotelFinder - Trova il tuo hotel perfetto</title>
</head>
<body>
    <!-- Header con gradiente moderno -->
    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-12 text-center text-white">
                    <h1 class="display-4 fw-bold mb-3 animate-fade-in">
                        🏨 HotelFinder
                    </h1>
                    <p class="lead mb-4 animate-slide-up">
                        Scopri l'hotel perfetto per il tuo prossimo viaggio
                    </p>
                </div>
            </div>
        </div>
    </header>

    <!-- Filtri con design moderno -->
    <section class="filters-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="filter-card">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h3 class="h5 mb-4 d-flex align-items-center">
                                    <i class="bi bi-funnel-fill me-2 text-primary"></i>
                                    Personalizza la tua ricerca
                                </h3>
                            </div>
                        </div>
                        
                        <form method="GET" action="" class="filter-form">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="minimum_vote" name="minimum_vote">
                                            <option value="0" <?php echo $min_vote == 0 ? 'selected' : ''; ?>>Tutte le valutazioni</option>
                                            <option value="1" <?php echo $min_vote == 1 ? 'selected' : ''; ?>>⭐ 1+ stelle</option>
                                            <option value="2" <?php echo $min_vote == 2 ? 'selected' : ''; ?>>⭐⭐ 2+ stelle</option>
                                            <option value="3" <?php echo $min_vote == 3 ? 'selected' : ''; ?>>⭐⭐⭐ 3+ stelle</option>
                                            <option value="4" <?php echo $min_vote == 4 ? 'selected' : ''; ?>>⭐⭐⭐⭐ 4+ stelle</option>
                                            <option value="5" <?php echo $min_vote == 5 ? 'selected' : ''; ?>>⭐⭐⭐⭐⭐ 5 stelle</option>
                                        </select>
                                        <label for="minimum_vote">Valutazione minima</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-check form-switch parking-switch">
                                        <input class="form-check-input" type="checkbox" id="parking" name="parking" value="on" 
                                               <?php echo $parking_requested ? 'checked' : ''; ?>>
                                        <label class="form-check-label d-flex align-items-center" for="parking">
                                            <i class="bi bi-car-front-fill me-2"></i>
                                            Solo con parcheggio
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-search w-100 h-100">
                                        <i class="bi bi-search me-1"></i>
                                        Cerca
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <!-- Status filtri attivi -->
                        <?php if($parking_requested || $min_vote > 0): ?>
                        <div class="active-filters mt-3">
                            <small class="text-muted">Filtri attivi:</small>
                            <?php if($parking_requested): ?>
                                <span class="badge bg-info ms-2">
                                    <i class="bi bi-car-front-fill me-1"></i>Parcheggio
                                </span>
                            <?php endif; ?>
                            <?php if($min_vote > 0): ?>
                                <span class="badge bg-warning text-dark ms-2">
                                    <i class="bi bi-star-fill me-1"></i><?php echo $min_vote; ?>+ stelle
                                </span>
                            <?php endif; ?>
                            <a href="?" class="btn btn-sm btn-outline-secondary ms-2">
                                <i class="bi bi-x-lg me-1"></i>Rimuovi filtri
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Risultati in formato card moderno -->
    <section class="results-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">
                            <i class="bi bi-buildings me-2 text-primary"></i>
                            Hotel disponibili 
                            <span class="badge bg-primary"><?php echo count($filteredHotels); ?></span>
                        </h2>
                    </div>
                </div>
            </div>
            
            <div class="row g-4">
                <?php foreach ($filteredHotels as $index => $hotel): ?>
                <div class="col-lg-6 col-xl-4">
                    <div class="hotel-card" style="animation-delay: <?php echo $index * 0.1; ?>s">
                        <div class="hotel-image">
                            <img src="<?php echo $hotel['image']; ?>" alt="<?php echo $hotel['name']; ?>" class="card-img-top">
                            <div class="hotel-badge">
                                <div class="rating-badge">
                                    <?php echo generateStars($hotel['vote']); ?>
                                    <small class="ms-1"><?php echo $hotel['vote']; ?>/5</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo $hotel['name']; ?></h5>
                            <p class="card-text text-muted mb-3"><?php echo $hotel['description']; ?></p>
                            
                            <div class="hotel-features mb-3">
                                <div class="feature">
                                    <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                                    <span><?php echo $hotel['distance_to_center']; ?> km dal centro</span>
                                </div>
                                <div class="feature">
                                    <?php if($hotel['parking']): ?>
                                        <i class="bi bi-car-front-fill text-success me-2"></i>
                                        <span class="text-success">Parcheggio disponibile</span>
                                    <?php else: ?>
                                        <i class="bi bi-x-circle-fill text-danger me-2"></i>
                                        <span class="text-muted">Parcheggio non disponibile</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="price">
                                    <span class="h5 fw-bold text-primary mb-0">€<?php echo $hotel['price']; ?></span>
                                    <small class="text-muted">/notte</small>
                                </div>
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye me-1"></i>Dettagli
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <?php if(empty($filteredHotels)): ?>
                <div class="col-12">
                    <div class="empty-state text-center py-5">
                        <i class="bi bi-search display-1 text-muted mb-3"></i>
                        <h3 class="text-muted">Nessun hotel trovato</h3>
                        <p class="text-muted">Prova a modificare i filtri di ricerca</p>
                        <a href="?" class="btn btn-primary">
                            <i class="bi bi-arrow-clockwise me-1"></i>Rimuovi filtri
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer moderno -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; 2025 HotelFinder. Progetto portfolio sviluppato con PHP e Bootstrap 5</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>