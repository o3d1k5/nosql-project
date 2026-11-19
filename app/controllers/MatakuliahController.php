<?php

use MongoDB\BSON\ObjectId;

class MatakuliahController
{
    private $collection;

    public function __construct($db)
    {
        $this->collection = $db->matakuliah;
    }

    public function index()
    {
        return $this->collection->find(
            [],
            ['sort' => ['kode' => 1]]
        )->toArray();
    }

    public function create($data)
    {
        $kode = trim($data['kode'] ?? '');

        if (!$kode || !$data['nama']) {
            throw new InvalidArgumentException('Data mata kuliah wajib diisi.');
        }

        if ($this->collection->findOne(['kode' => $kode])) {
            throw new InvalidArgumentException('Kode mata kuliah sudah ada.');
        }

        $this->collection->insertOne([
            'kode' => $kode,
            'nama' => trim($data['nama']),
            'sks' => (int)$data['sks'],
            'semester' => (int)$data['semester'],
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
    }

    public function update($id, $data)
    {
        $this->collection->updateOne(
            ['_id' => new ObjectId($id)],
            ['$set' => [
                'kode' => trim($data['kode']),
                'nama' => trim($data['nama']),
                'sks' => (int)$data['sks'],
                'semester' => (int)$data['semester']
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