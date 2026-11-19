<?php

use MongoDB\BSON\ObjectId;

class KrsController
{
    private $krs;
    private $mahasiswa;
    private $matakuliah;

    public function __construct($db)
    {
        $this->krs = $db->krs;
        $this->mahasiswa = $db->mahasiswa;
        $this->matakuliah = $db->matakuliah;
    }

    public function index()
    {
        return $this->krs->find(
            [],
            ['sort' => ['created_at' => -1]]
        )->toArray();
    }

    public function create($data)
    {
        $mahasiswa = $this->mahasiswa->findOne([
            '_id' => new ObjectId($data['mahasiswa_id'])
        ]);

        $matakuliah = $this->matakuliah->findOne([
            '_id' => new ObjectId($data['matakuliah_id'])
        ]);

        if (!$mahasiswa || !$matakuliah) {
            throw new InvalidArgumentException(
                'Mahasiswa atau mata kuliah tidak ditemukan.'
            );
        }

        $semester = trim($data['semester'] ?? '');

        if ($semester === '') {
            throw new InvalidArgumentException('Semester wajib diisi.');
        }

        if ($this->krs->findOne([
            'mahasiswa_id' => $mahasiswa['_id'],
            'matakuliah_id' => $matakuliah['_id'],
            'semester' => $semester
        ])) {
            throw new InvalidArgumentException(
                'Mata kuliah sudah diambil pada semester tersebut.'
            );
        }

        $this->krs->insertOne([
            'mahasiswa_id' => $mahasiswa['_id'],
            'nama_mahasiswa' => $mahasiswa['nama'],
            'matakuliah_id' => $matakuliah['_id'],
            'nama_matakuliah' => $matakuliah['nama'],
            'sks' => $matakuliah['sks'],
            'semester' => $semester,
            'status' => 'Diajukan',
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
    }

    public function delete($id)
    {
        $this->krs->deleteOne([
            '_id' => new ObjectId($id)
        ]);
    }
}