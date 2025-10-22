<?php
// =============================================
// HOTEL DIRECTORY - ENTERPRISE VERSION 2.0.0
// =============================================

// Error handling and security headers
error_reporting(E_ALL);
ini_set('display_errors', 0); // Hide in production
ini_set('log_errors', 1);
ini_set('error_log', 'logs/php_errors.log');

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Performance headers
header('Cache-Control: public, max-age=3600');
header('Vary: Accept-Encoding');

// Helper functions for input validation (Junior-level approach)
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function validateInteger($value, $min = null, $max = null) {
    $int = filter_var($value, FILTER_VALIDATE_INT);
    if ($int === false) return false;
    
    if ($min !== null && $int < $min) return false;
    if ($max !== null && $int > $max) return false;
    
    return $int;
}

// Hotel data with validation
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

// Simple input handling with basic validation
$parking_requested = isset($_GET['parking']) && $_GET['parking'] === 'on';
$min_vote = validateInteger($_GET['minimum_vote'] ?? 1, 1, 5) ?: 1;

// Filter hotels based on user input
$filteredHotels = [];
foreach ($hotels as $hotel) {
    // Check parking requirement
    if ($parking_requested && !$hotel['parking']) {
        continue; // Skip this hotel
    }
    
    // Check minimum rating
    if ($hotel['vote'] < $min_vote) {
        continue; // Skip this hotel
    }
    
    // Hotel meets criteria, add to results
    $filteredHotels[] = $hotel;
}

// Log for debugging (simple approach)
if (empty($filteredHotels)) {
    error_log("No hotels found with filters: parking=" . ($parking_requested ? 'yes' : 'no') . ", min_vote=" . $min_vote);
}

?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Directory professionale di hotel con filtri avanzati, dark mode e design moderno. Trova l'hotel perfetto per il tuo soggiorno.">
    <meta name="keywords" content="hotel, prenotazioni, viaggi, turismo, directory hotel, booking">
    <meta name="author" content="Fabio Bianco">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Hotel Directory - Portfolio Project">
    <meta property="og:description" content="Progetto portfolio sviluppato con PHP, CSS moderno e JavaScript vanilla">
    <meta property="og:type" content="website">
    
    <!-- Theme Color -->
    <!-- Security Headers -->
    <meta http-equiv="Content-Security-Policy" 
          content="default-src 'self'; 
                   script-src 'self' 'unsafe-inline' https://www.googletagmanager.com https://www.google-analytics.com;
                   style-src 'self' 'unsafe-inline' https://fonts.googleapis.com;
                   img-src 'self' https://images.unsplash.com https://via.placeholder.com data:;
                   font-src 'self' https://fonts.gstatic.com;
                   connect-src 'self' https://www.google-analytics.com;
                   object-src 'none';
                   base-uri 'self';
                   form-action 'self';">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    
    <!-- Theme & Performance -->
    <meta name="theme-color" content="#007fad">
    <meta name="color-scheme" content="light dark">
    
    <title>Hotel Directory - Enterprise Portfolio Project</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://images.unsplash.com">
</head>

<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="header-text">
                    <h1>Hotel Scanner</h1>
                    <p class="subtitle">Trova l'hotel perfetto per il tuo soggiorno</p>
                </div>
                <div class="header-controls">
                    <button class="theme-toggle" id="themeToggle" aria-label="Cambia tema">
                        <span class="theme-icon sun-icon">☀️</span>
                        <span class="theme-icon moon-icon">🌙</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <section class="filters">
        <div class="container">
            <div class="filters-header">
                <button type="button" class="filters-toggle" id="filtersToggle" aria-expanded="false" aria-controls="filterForm">
                    <span class="filters-title">🔍 Filtri di ricerca</span>
                    <span class="toggle-icon">▼</span>
                </button>
            </div>
            
            <div class="filters-content" id="filterForm" aria-hidden="true">
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

                    <div class="filter-actions">
                        <button type="submit" class="btn-filter">Cerca hotel</button>
                        <button type="button" class="btn-reset" id="resetFilters">Reset</button>
                    </div>
                </form>
            </div>
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
                        <article class="hotel-card" role="article" tabindex="0" aria-labelledby="hotel-<?php echo $hotel['vote'] . '-' . str_replace(' ', '-', strtolower($hotel['name'])); ?>">
                            <div class="hotel-image">
                                <img src="<?php echo $hotel['image']; ?>" 
                                     alt="Immagine dell'hotel <?php echo htmlspecialchars($hotel['name']); ?>" 
                                     loading="lazy"
                                     width="400"
                                     height="250">
                                <div class="price-badge" aria-label="Prezzo per notte">€<?php echo $hotel['price']; ?>/notte</div>
                            </div>
                            
                            <div class="hotel-content">
                                <div class="hotel-header">
                                    <h2 class="hotel-name" id="hotel-<?php echo $hotel['vote'] . '-' . str_replace(' ', '-', strtolower($hotel['name'])); ?>"><?php echo htmlspecialchars($hotel['name']); ?></h2>
                                    <div class="hotel-rating" aria-label="Valutazione hotel: <?php echo $hotel['vote']; ?> stelle su 5">
                                        <div class="rating-stars" role="img" aria-label="<?php echo $hotel['vote']; ?> stelle su 5">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <span class="star <?php echo $i <= $hotel['vote'] ? 'filled' : ''; ?>" aria-hidden="true">★</span>
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
                                    <button class="btn-view-details" aria-label="Vedi dettagli di <?php echo htmlspecialchars($hotel['name']); ?>">
                                        Vedi dettagli
                                    </button>
                                    <button class="btn-book" aria-label="Prenota <?php echo htmlspecialchars($hotel['name']); ?>">
                                        Prenota ora
                                    </button>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- LOADING OVERLAY -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <p>Caricamento hotel...</p>
    </div>

    <script>
        // ========================================
        // FILTERS SYSTEM
        // ========================================
        class FiltersManager {
            constructor() {
                this.filtersToggle = document.getElementById('filtersToggle');
                this.filtersContent = document.getElementById('filterForm');
                this.resetButton = document.getElementById('resetFilters');
                this.init();
            }

            init() {
                this.setupToggle();
                this.setupReset();
                this.updateFiltersCount();
            }

            setupToggle() {
                if (this.filtersToggle) {
                    this.filtersToggle.addEventListener('click', () => {
                        this.toggleFilters();
                    });
                }
            }

            toggleFilters() {
                const isExpanded = this.filtersToggle.getAttribute('aria-expanded') === 'true';
                
                this.filtersToggle.setAttribute('aria-expanded', !isExpanded);
                this.filtersContent.setAttribute('aria-hidden', isExpanded);
                
                if (!isExpanded) {
                    this.filtersContent.classList.add('expanded');
                } else {
                    this.filtersContent.classList.remove('expanded');
                }
            }

            setupReset() {
                if (this.resetButton) {
                    this.resetButton.addEventListener('click', () => {
                        window.location.href = window.location.pathname;
                    });
                }
            }

            updateFiltersCount() {
                // Auto-expand if filters are active
                const urlParams = new URLSearchParams(window.location.search);
                const hasActiveFilters = urlParams.has('parking') || 
                                       (urlParams.has('minimum_vote') && urlParams.get('minimum_vote') !== '1');
                
                if (hasActiveFilters) {
                    this.filtersToggle.setAttribute('aria-expanded', 'true');
                    this.filtersContent.setAttribute('aria-hidden', 'false');
                    this.filtersContent.classList.add('expanded');
                }
            }
        }

        // ========================================
        // DARK MODE SYSTEM
        // ========================================
        class ThemeManager {
            constructor() {
                this.theme = localStorage.getItem('theme') || 'light';
                this.init();
            }

            init() {
                this.applyTheme(this.theme);
                this.setupToggle();
            }

            applyTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
                this.theme = theme;
            }

            toggleTheme() {
                const newTheme = this.theme === 'light' ? 'dark' : 'light';
                this.applyTheme(newTheme);
            }

            setupToggle() {
                const toggle = document.getElementById('themeToggle');
                if (toggle) {
                    toggle.addEventListener('click', () => this.toggleTheme());
                }
            }
        }

        // ========================================
        // ANIMAZIONI E PERFORMANCE
        // ========================================
        class AnimationManager {
            constructor() {
                this.setupScrollAnimations();
                this.setupLoadingStates();
            }

            setupScrollAnimations() {
                const cards = document.querySelectorAll('.hotel-card');
                
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry, index) => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                entry.target.classList.add('animate-in');
                            }, index * 100); // Stagger effect
                        }
                    });
                }, { threshold: 0.1 });

                cards.forEach(card => observer.observe(card));
            }

            // Card hover animations rimossi per design più pulito

            setupLoadingStates() {
                // Simula loading iniziale
                window.addEventListener('load', () => {
                    setTimeout(() => {
                        document.getElementById('loadingOverlay').classList.add('fade-out');
                    }, 500);
                });
            }
        }

        // ========================================
        // ACCESSIBILITY ENHANCEMENTS
        // ========================================
        class AccessibilityManager {
            constructor() {
                this.setupKeyboardNavigation();
                this.setupFocusManagement();
            }

            setupKeyboardNavigation() {
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Tab') {
                        document.body.classList.add('keyboard-navigation');
                    }
                });

                document.addEventListener('mousedown', () => {
                    document.body.classList.remove('keyboard-navigation');
                });
            }

            setupFocusManagement() {
                const focusableElements = document.querySelectorAll(
                    'button, input, select, textarea, [tabindex]:not([tabindex="-1"])'
                );
                
                focusableElements.forEach(element => {
                    element.addEventListener('focus', () => {
                        element.classList.add('focused');
                    });
                    
                    element.addEventListener('blur', () => {
                        element.classList.remove('focused');
                    });
                });
            }
        }

        // ========================================
        // BASIC PERFORMANCE TRACKING (Junior Level)
        // ========================================
        class SimplePerformance {
            constructor() {
                this.trackLoadTime();
            }
            
            trackLoadTime() {
                window.addEventListener('load', () => {
                    const loadTime = performance.now();
                    console.log(`🚀 Page loaded in ${Math.round(loadTime)}ms`);
                    
                    // Simple performance tips for future
                    if (loadTime > 3000) {
                        console.warn('⚠️ Page load time is slow. Consider optimizing images or scripts.');
                    }
                });
            }
        }

        // INIZIALIZZAZIONE (Junior Developer Level)
        document.addEventListener('DOMContentLoaded', () => {
            console.log('🏨 Hotel Directory v2.0.0 - Loading...');
            
            // Initialize core features
            new FiltersManager();
            new ThemeManager(); 
            new AnimationManager();
            new AccessibilityManager();
            new SimplePerformance();
            
            console.log('✅ Hotel Directory - Ready!');
        });
    </script>
</body>
</html>