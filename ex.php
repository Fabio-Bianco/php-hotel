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

// Codice pulito e ottimizzato

?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Directory</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="container">
            <h1>Hotel Directory</h1>
            <p class="subtitle">Trova l'hotel perfetto per il tuo soggiorno</p>
        </div>
    </header>

    <section class="filters">
        <div class="container">
            <form class="filter-form" method="GET">
                <div class="filter-group">
                    <label for="minimum_vote">Valutazione minima</label>
                    <select name="minimum_vote" id="minimum_vote" class="filter-input">
                        <option value="1" <?php echo $min_vote == 1 ? 'selected' : ''; ?>>1+</option>
                        <option value="2" <?php echo $min_vote == 2 ? 'selected' : ''; ?>>2+</option>
                        <option value="3" <?php echo $min_vote == 3 ? 'selected' : ''; ?>>3+</option>
                        <option value="4" <?php echo $min_vote == 4 ? 'selected' : ''; ?>>4+</option>
                        <option value="5" <?php echo $min_vote == 5 ? 'selected' : ''; ?>>5</option>
                    </select>
                </div>

                <div class="checkbox-wrapper">
                    <label>Servizi aggiuntivi</label>
                    <div class="checkbox-group">
                        <input type="checkbox" name="parking" id="parking" <?php echo $parking_requested ? 'checked' : ''; ?>>
                        <label for="parking">Parcheggio disponibile</label>
                    </div>
                </div>

                <button type="submit" class="btn-filter">Cerca hotel</button>
            </form>
        </div>
    </section>

    <section class="hotels-section">
        <div class="container">
            <?php if (empty($filteredHotels)): ?>
                <div class="empty-state">
                    <h3>Nessun hotel trovato</h3>
                    <p>Prova a modificare i filtri di ricerca</p>
                </div>
            <?php else: ?>
                <div class="hotels-grid">
                    <?php foreach ($filteredHotels as $hotel): ?>
                        <article class="hotel-card">
                            <div class="hotel-image">
                                <img src="<?php echo $hotel['image']; ?>" alt="<?php echo htmlspecialchars($hotel['name']); ?>" loading="lazy">
                                <div class="price-badge">€<?php echo $hotel['price']; ?>/notte</div>
                            </div>
                            
                            <div class="hotel-content">
                                <div class="hotel-header">
                                    <h2 class="hotel-name"><?php echo htmlspecialchars($hotel['name']); ?></h2>
                                    <div class="hotel-rating">
                                        <span class="rating-score"><?php echo $hotel['vote']; ?></span>
                                        <div class="rating-stars">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <span class="star <?php echo $i <= $hotel['vote'] ? 'filled' : ''; ?>">★</span>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <p class="hotel-description">
                                    <?php echo htmlspecialchars($hotel['description']); ?>
                                </p>
                                
                                <div class="hotel-features">
                                    <div class="feature-item">
                                        <span class="feature-icon">🅿️</span>
                                        <div class="feature-content">
                                            <span class="feature-label">Parcheggio</span>
                                            <span class="feature-value <?php echo $hotel['parking'] ? 'parking-yes' : 'parking-no'; ?>">
                                                <?php echo $hotel['parking'] ? 'Disponibile' : 'Non disponibile'; ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="feature-item">
                                        <span class="feature-icon">📍</span>
                                        <div class="feature-content">
                                            <span class="feature-label">Distanza centro</span>
                                            <span class="feature-value distance-value">
                                                <?php echo number_format($hotel['distance_to_center'], 1, ',', '.'); ?> km
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="hotel-actions">
                                    <button class="btn-view-details">Vedi dettagli</button>
                                    <button class="btn-book">Prenota ora</button>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>