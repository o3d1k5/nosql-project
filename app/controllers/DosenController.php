<?php

use MongoDB\BSON\ObjectId;

class DosenController
{
    private $collection;

    public function __construct($db)
    {
        $this->collection = $db->dosen;
    }

    public function index()
    {
        return $this->collection->find(
            [],
            ['sort' => ['nama' => 1]]
        )->toArray();
    }

    public function create($data)
    {
        $nidn = trim($data['nidn'] ?? '');
        $nama = trim($data['nama'] ?? '');
        $email = trim($data['email'] ?? '');

        if (!$nidn || !$nama || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Data dosen tidak valid.');
        }

        if ($this->collection->findOne(['nidn' => $nidn])) {
            throw new InvalidArgumentException('NIDN sudah terdaftar.');
        }

        $this->collection->insertOne([
            'nidn' => $nidn,
            'nama' => $nama,
            'email' => $email,
            'program_studi' => trim($data['program_studi'] ?? ''),
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
    }

    public function update($id, $data)
    {
        $this->collection->updateOne(
            ['_id' => new ObjectId($id)],
            ['$set' => [
                'nidn' => trim($data['nidn'] ?? ''),
                'nama' => trim($data['nama'] ?? ''),
                'email' => trim($data['email'] ?? ''),
                'program_studi' => trim($data['program_studi'] ?? '')
            ]]
        );
    }

    public function delete($id)
    {
        $this->collection->deleteOne([
            '_id' => new ObjectId($id)
        ]);
    }
}