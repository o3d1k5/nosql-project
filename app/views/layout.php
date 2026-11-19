<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= e($title) ?> - SIAKAD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="assets/style.css" rel="stylesheet">
</head>

<body>

<div class="d-flex">

    <aside class="sidebar p-3">
        <h4 class="text-white mb-4">SIAKAD</h4>

        <a href="?page=dashboard">Dashboard</a>
        <a href="?page=mahasiswa">Mahasiswa</a>
        <a href="?page=dosen">Dosen</a>
        <a href="?page=matakuliah">Mata Kuliah</a>
        <a href="?page=krs">KRS</a>
        <a href="?page=laporan">Laporan</a>

        <hr class="text-white">

        <a href="?page=logout">Logout</a>
    </aside>

    <main class="main-content flex-grow-1 p-4">

        <div class="d-flex justify-content-between mb-4">
            <h3><?= e($title) ?></h3>
            <span>Admin: <?= e($_SESSION['admin_name']) ?></span>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?= e($success) ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?= e($error) ?>
            </div>
        <?php endif; ?>

        <?php require $content; ?>

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>