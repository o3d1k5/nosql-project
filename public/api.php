<?php

require_once __DIR__ . '/../app/config/database.php';

header('Content-Type: application/json');

$apiKey = getenv('API_KEY') ?: '';

$providedKey = $_SERVER['HTTP_X_API_KEY'] ?? '';

if (
    $apiKey === '' ||
    !hash_equals($apiKey, $providedKey)
) {
    http_response_code(401);

    echo json_encode([
        'status' => false,
        'message' => 'Unauthorized'
    ]);

    exit;
}

$resource = $_GET['resource'] ?? '';

$allowed = [
    'mahasiswa',
    'dosen',
    'matakuliah'
];

if (!in_array($resource, $allowed, true)) {

    http_response_code(404);

    echo json_encode([
        'status' => false,
        'message' => 'Resource tidak ditemukan'
    ]);

    exit;
}

$collection = $db->$resource;

$method = $_SERVER['REQUEST_METHOD'];

try {

    if ($method === 'GET') {

        $data = $collection->find(
            [],
            ['limit' => 100]
        )->toArray();

        $result = [];

        foreach ($data as $row) {
            $result[] = json_decode(
                MongoDB\BSON\Document::fromPHP($row)->toRelaxedExtendedJSON(),
                true
            );
        }

        echo json_encode([
            'status' => true,
            'data' => $result
        ]);

        exit;
    }

    if ($method === 'POST') {

        $input = json_decode(
            file_get_contents('php://input'),
            true
        );

        if (!is_array($input)) {
            throw new InvalidArgumentException('JSON tidak valid.');
        }

        if ($resource === 'mahasiswa') {

            foreach (['nim', 'nama', 'email', 'jurusan'] as $field) {
                if (empty($input[$field])) {
                    throw new InvalidArgumentException(
                        "Field $field wajib diisi."
                    );
                }
            }

            if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException('Email tidak valid.');
            }

            if ($collection->findOne(['nim' => $input['nim']])) {
                throw new InvalidArgumentException('NIM sudah digunakan.');
            }

            $document = [
                'nim' => trim($input['nim']),
                'nama' => trim($input['nama']),
                'email' => trim($input['email']),
                'jurusan' => trim($input['jurusan']),
                'angkatan' => (int)($input['angkatan'] ?? date('Y')),
                'status' => 'Aktif',
                'created_at' => new MongoDB\BSON\UTCDateTime()
            ];

        } elseif ($resource === 'dosen') {

            foreach (['nidn', 'nama', 'email'] as $field) {
                if (empty($input[$field])) {
                    throw new InvalidArgumentException(
                        "Field $field wajib diisi."
                    );
                }
            }

            if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException('Email tidak valid.');
            }

            $document = [
                'nidn' => trim($input['nidn']),
                'nama' => trim($input['nama']),
                'email' => trim($input['email']),
                'program_studi' => trim($input['program_studi'] ?? '')
            ];

        } else {

            foreach (['kode', 'nama', 'sks', 'semester'] as $field) {
                if (!isset($input[$field]) || $input[$field] === '') {
                    throw new InvalidArgumentException(
                        "Field $field wajib diisi."
                    );
                }
            }

            $document = [
                'kode' => trim($input['kode']),
                'nama' => trim($input['nama']),
                'sks' => (int)$input['sks'],
                'semester' => (int)$input['semester']
            ];
        }

        $insert = $collection->insertOne($document);

        http_response_code(201);

        echo json_encode([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
            'id' => (string)$insert->getInsertedId()
        ]);

        exit;
    }

    http_response_code(405);

    echo json_encode([
        'status' => false,
        'message' => 'Method tidak didukung'
    ]);

} catch (Throwable $e) {

    http_response_code(400);

    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}