<?php

class DashboardController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        return [
            'mahasiswa' => $this->db->mahasiswa->countDocuments(),
            'dosen' => $this->db->dosen->countDocuments(),
            'matakuliah' => $this->db->matakuliah->countDocuments(),
            'krs' => $this->db->krs->countDocuments()
        ];
    }
}