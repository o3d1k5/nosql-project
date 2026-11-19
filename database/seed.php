<?php

require_once __DIR__ . '/../app/config/database.php';

echo "Memulai database seeding...\n";

// ADMIN
$db->users->updateOne(
    ['email' => 'admin@siakad.local'],
    [
        '$set' => [
            'name' => 'Administrator',
            'email' => 'admin@siakad.local',
            'password' => password_hash(
                'Admin123!',
                PASSWORD_DEFAULT
            ),
            'role' => 'admin'
        ]
    ],
    ['upsert' => true]
);

// MAHASISWA
$students = [
    [
        'nim' => '20260001',
        'nama' => 'Budi Santoso',
        'email' => 'budi@gmail.com',
        'jurusan' => 'Informatika',
        'angkatan' => 2026,
        'status' => 'Aktif'
    ],
    [
        'nim' => '20260002',
        'nama' => 'Siti Aminah',
        'email' => 'siti@gmail.com',
        'jurusan' => 'Sistem Informasi',
        'angkatan' => 2026,
        'status' => 'Aktif'
    ],
    [
        'nim' => '20250001',
        'nama' => 'Andi Wijaya',
        'email' => 'andi@gmail.com',
        'jurusan' => 'Informatika',
        'angkatan' => 2025,
        'status' => 'Aktif'
    ]
];

foreach ($students as $student) {

    $db->mahasiswa->updateOne(
        ['nim' => $student['nim']],
        ['$set' => $student],
        ['upsert' => true]
    );

}

// DOSEN
$lecturers = [
    [
        'nidn' => '0012345678',
        'nama' => 'Dr. Ahmad',
        'email' => 'ahmad@kampus.ac.id',
        'program_studi' => 'Informatika'
    ],
    [
        'nidn' => '0012345679',
        'nama' => 'Dr. Rina',
        'email' => 'rina@kampus.ac.id',
        'program_studi' => 'Sistem Informasi'
    ]
];

foreach ($lecturers as $lecturer) {

    $db->dosen->updateOne(
        ['nidn' => $lecturer['nidn']],
        ['$set' => $lecturer],
        ['upsert' => true]
    );

}

// MATA KULIAH
$courses = [
    [
        'kode' => 'IF101',
        'nama' => 'Pemrograman Web',
        'sks' => 3,
        'semester' => 2
    ],
    [
        'kode' => 'IF102',
        'nama' => 'Basis Data',
        'sks' => 3,
        'semester' => 2
    ],
    [
        'kode' => 'IF103',
        'nama' => 'Pemrograman Java',
        'sks' => 3,
        'semester' => 2
    ],
    [
        'kode' => 'SI101',
        'nama' => 'Analisis Sistem Informasi',
        'sks' => 3,
        'semester' => 3
    ]
];

foreach ($courses as $course) {

    $db->matakuliah->updateOne(
        ['kode' => $course['kode']],
        ['$set' => $course],
        ['upsert' => true]
    );

}

// INDEX
$db->mahasiswa->createIndex(
    ['nim' => 1],
    ['unique' => true]
);

$db->dosen->createIndex(
    ['nidn' => 1],
    ['unique' => true]
);

$db->matakuliah->createIndex(
    ['kode' => 1],
    ['unique' => true]
);

echo "Database seeding selesai!\n";