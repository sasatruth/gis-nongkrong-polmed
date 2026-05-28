<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nongkrong Polmed GIS</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --brown:  #7A4E2D;
            --cream:  #F8EFE3;
            --coffee: #A97142;
            --dark:   #2B1B12;
        }

        body {
            background: var(--cream);
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
        }

        .navbar-polmed {
            background: var(--brown);
        }

        .navbar-polmed .navbar-brand,
        .navbar-polmed .nav-link {
            color: #fff !important;
        }

        .navbar-polmed .nav-link:hover {
            color: #ffc107 !important;
        }

        .card-cafe {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(122,78,45,.10);
        }

        .badge-fasilitas {
            background: #fff3cd;
            color: var(--brown);
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 500;
        }

        .btn-coklat {
            background: var(--brown);
            color: #fff;
            border: none;
        }

        .btn-coklat:hover {
            background: var(--coffee);
            color: #fff;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-polmed px-3">
    <a class="navbar-brand fw-bold" href="/">
        ☕ Nongkrong Polmed GIS
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="/"><i class="bi bi-house"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/map"><i class="bi bi-map"></i> Peta GIS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/tempat"><i class="bi bi-gear"></i> Admin</a>
            </li>
        </ul>
    </div>
</nav>

<main>
    <?= $this->renderSection('content') ?>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<?= $this->renderSection('scripts') ?>

</body>
</html>