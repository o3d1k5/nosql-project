<div class="card p-4">

    <h5>Laporan Data Mahasiswa</h5>

    <p>
        Download seluruh data mahasiswa atau gunakan
        pencarian untuk membatasi hasil laporan.
    </p>

    <form method="GET" class="d-flex gap-2">

        <input type="hidden" name="page" value="laporan">

        <input name="q"
               class="form-control"
               placeholder="Cari NIM, nama, atau jurusan">

        <button class="btn btn-primary">
            Cari dan Download CSV
        </button>

    </form>

    <a href="?page=laporan&export=1"
       class="btn btn-success mt-3">
        Download Semua Data
    </a>

</div>