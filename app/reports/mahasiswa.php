<?php

$filter = [];

if (!empty($_GET['q'])) {

    $regex = new MongoDB\BSON\Regex(
        preg_quote($_GET['q']),
        'i'
    );

    $filter = [
        '$or' => [
            ['nim' => $regex],
            ['nama' => $regex],
            ['jurusan' => $regex]
        ]
    ];
}

$data = $db->mahasiswa->find(
    $filter,
    ['sort' => ['nama' => 1]]
);

header('Content-Type: text/csv; charset=UTF-8');

header(
    'Content-Disposition: attachment; filename="laporan_mahasiswa.csv"'
);

$output = fopen('php://output', 'w');

fwrite($output, "\xEF\xBB\xBF");

fputcsv($output, [
    'NIM',
    'Nama',
    'Email',
    'Jurusan',
    'Angkatan',
    'Status'
], ';');

foreach ($data as $m) {

    fputcsv($output, [
        $m['nim'] ?? '',
        $m['nama'] ?? '',
        $m['email'] ?? '',
        $m['jurusan'] ?? '',
        $m['angkatan'] ?? '',
        $m['status'] ?? ''
    ], ';');

}

fclose($output);
exit;