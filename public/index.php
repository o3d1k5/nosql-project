<?php

session_start();

require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/helpers/functions.php';
require_once __DIR__ . '/../app/middleware/auth.php';

require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/DashboardController.php';
require_once __DIR__ . '/../app/controllers/MahasiswaController.php';
require_once __DIR__ . '/../app/controllers/DosenController.php';
require_once __DIR__ . '/../app/controllers/MatakuliahController.php';
require_once __DIR__ . '/../app/controllers/KrsController.php';

$page = $_GET['page'] ?? 'dashboard';

$auth = new AuthController($db);

if ($page === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $error = $auth->login();
}

if ($page === 'logout') {
    $auth->logout();
}

if ($page === 'login' && empty($_SESSION['admin_id'])) {
    require __DIR__ . '/../app/views/login.php';
    exit;
}

require_login();

$mahasiswa = new MahasiswaController($db);
$dosen = new DosenController($db);
$matakuliah = new MatakuliahController($db);
$krs = new KrsController($db);

$error = null;
$success = null;

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        verify_csrf();

        switch ($page) {

            case 'mahasiswa':
                if (isset($_POST['delete_id'])) {
                    $mahasiswa->delete($_POST['delete_id']);
                } elseif (!empty($_POST['id'])) {
                    $mahasiswa->update($_POST['id'], $_POST);
                } else {
                    $mahasiswa->create($_POST);
                }
                $success = 'Data mahasiswa berhasil diproses.';
                break;

            case 'dosen':
                if (isset($_POST['delete_id'])) {
                    $dosen->delete($_POST['delete_id']);
                } elseif (!empty($_POST['id'])) {
                    $dosen->update($_POST['id'], $_POST);
                } else {
                    $dosen->create($_POST);
                }
                $success = 'Data dosen berhasil diproses.';
                break;

            case 'matakuliah':
                if (isset($_POST['delete_id'])) {
                    $matakuliah->delete($_POST['delete_id']);
                } elseif (!empty($_POST['id'])) {
                    $matakuliah->update($_POST['id'], $_POST);
                } else {
                    $matakuliah->create($_POST);
                }
                $success = 'Data mata kuliah berhasil diproses.';
                break;

            case 'krs':
                if (isset($_POST['delete_id'])) {
                    $krs->delete($_POST['delete_id']);
                } else {
                    $krs->create($_POST);
                }
                $success = 'Data KRS berhasil diproses.';
                break;
        }
    }

} catch (Throwable $e) {
    $error = $e->getMessage();
}

if ($success) {
    $_SESSION['flash'] = $success;
    redirect('?page=' . $page);
}

$success = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$title = 'Dashboard';
$content = '';

switch ($page) {

    case 'dashboard':
        $title = 'Dashboard Akademik';
        $stats = (new DashboardController($db))->index();
        $content = __DIR__ . '/../app/views/dashboard.php';
        break;

    case 'mahasiswa':
        $title = 'Data Mahasiswa';
        $result = $mahasiswa->index();
        $edit = !empty($_GET['edit'])
            ? $mahasiswa->find($_GET['edit'])
            : null;
        $content = __DIR__ . '/../app/views/mahasiswa.php';
        break;

    case 'dosen':
        $title = 'Data Dosen';
        $rows = $dosen->index();
        $content = __DIR__ . '/../app/views/dosen.php';
        break;

    case 'matakuliah':
        $title = 'Data Mata Kuliah';
        $rows = $matakuliah->index();
        $content = __DIR__ . '/../app/views/matakuliah.php';
        break;

    case 'krs':
        $title = 'Kartu Rencana Studi';
        $rows = $krs->index();
        $students = $db->mahasiswa->find()->toArray();
        $courses = $db->matakuliah->find()->toArray();
        $content = __DIR__ . '/../app/views/krs.php';
        break;

    case 'laporan':
        if (isset($_GET['export'])) {
            require __DIR__ . '/../app/reports/mahasiswa.php';
            exit;
        }

        $title = 'Laporan Akademik';
        $content = __DIR__ . '/../app/views/laporan.php';
        break;

    default:
        http_response_code(404);
        exit('Halaman tidak ditemukan.');
}

require __DIR__ . '/../app/views/layout.php';