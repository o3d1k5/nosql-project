<?php

use MongoDB\BSON\ObjectId;

class MahasiswaController
{
    private $collection;

    public function __construct($db)
    {
        $this->collection = $db->mahasiswa;
    }

    // READ + SEARCH + PAGINATION
    public function index()
    {
        $keyword = trim($_GET['q'] ?? '');

        $page = max(1, (int)($_GET['p'] ?? 1));
        $limit = 10;
        $skip = ($page - 1) * $limit;

        $filter = [];

        if ($keyword !== '') {
            $regex = new MongoDB\BSON\Regex(
                preg_quote($keyword),
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

        $total = $this->collection->countDocuments($filter);

        $data = $this->collection->find(
            $filter,
            [
                'sort' => ['nama' => 1],
                'skip' => $skip,
                'limit' => $limit
            ]
        )->toArray();

        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'pages' => max(1, (int)ceil($total / $limit)),
            'keyword' => $keyword
        ];
    }

    // CREATE
    public function create($data)
    {
        $nim = trim($data['nim'] ?? '');
        $nama = trim($data['nama'] ?? '');
        $email = trim($data['email'] ?? '');
        $jurusan = trim($data['jurusan'] ?? '');

        if (!$nim || !$nama || !$email || !$jurusan) {
            throw new InvalidArgumentException(
                'Semua field wajib diisi.'
            );
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                'Email tidak valid.'
            );
        }

        if ($this->collection->findOne(['nim' => $nim])) {
            throw new InvalidArgumentException(
                'NIM sudah terdaftar.'
            );
        }

        $this->collection->insertOne([
            'nim' => $nim,
            'nama' => $nama,
            'email' => $email,
            'jurusan' => $jurusan,
            'angkatan' => (int)($data['angkatan'] ?? date('Y')),
            'status' => 'Aktif',
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
    }

    // UPDATE
    public function update($id, $data)
    {
        $nim = trim($data['nim'] ?? '');
        $nama = trim($data['nama'] ?? '');
        $email = trim($data['email'] ?? '');
        $jurusan = trim($data['jurusan'] ?? '');

        if (!$nim || !$nama || !$email || !$jurusan) {
            throw new InvalidArgumentException(
                'Semua field wajib diisi.'
            );
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                'Email tidak valid.'
            );
        }

        $this->collection->updateOne(
            [
                '_id' => new ObjectId($id),
                'nim' => ['$ne' => '__invalid__']
            ],
            [
                '$set' => [
                    'nim' => $nim,
                    'nama' => $nama,
                    'email' => $email,
                    'jurusan' => $jurusan,
                    'angkatan' => (int)($data['angkatan'] ?? date('Y')),
                    'status' => $data['status'] ?? 'Aktif',
                    'updated_at' => new MongoDB\BSON\UTCDateTime()
                ]
            ]
        );
    }

    // DELETE
    public function delete($id)
    {
        $this->collection->deleteOne([
            '_id' => new ObjectId($id)
        ]);
    }

    public function find($id)
    {
        return $this->collection->findOne([
            '_id' => new ObjectId($id)
        ]);
    }
}