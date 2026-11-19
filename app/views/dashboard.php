<div class="row g-3">

<?php
$cards = [
    'Mahasiswa' => $stats['mahasiswa'],
    'Dosen' => $stats['dosen'],
    'Mata Kuliah' => $stats['matakuliah'],
    'KRS' => $stats['krs']
];
?>

<?php foreach ($cards as $label => $value): ?>

    <div class="col-md-3">

        <div class="stat-card">

            <h6><?= e($label) ?></h6>

            <h2><?= e($value) ?></h2>

        </div>

    </div>

<?php endforeach; ?>

</div>

<div class="card mt-4 p-4">

    <h5>Selamat Datang di Sistem Informasi Akademik</h5>

    <p>
        Aplikasi pengelolaan data akademik berbasis
        PHP dan MongoDB.
    </p>

</div>