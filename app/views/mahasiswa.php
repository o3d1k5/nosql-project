<div class="card p-3 mb-4">

    <h5><?= $edit ? 'Edit Mahasiswa' : 'Tambah Mahasiswa' ?></h5>

    <form method="POST">

        <input type="hidden"
               name="csrf_token"
               value="<?= e(csrf_token()) ?>">

        <input type="hidden"
               name="id"
               value="<?= e($edit['_id'] ?? '') ?>">

        <div class="row g-2">

            <div class="col-md-2">
                <input name="nim"
                       class="form-control"
                       placeholder="NIM"
                       required
                       value="<?= e($edit['nim'] ?? '') ?>">
            </div>

            <div class="col-md-3">
                <input name="nama"
                       class="form-control"
                       placeholder="Nama"
                       required
                       value="<?= e($edit['nama'] ?? '') ?>">
            </div>

            <div class="col-md-3">
                <input name="email"
                       type="email"
                       class="form-control"
                       placeholder="Email"
                       required
                       value="<?= e($edit['email'] ?? '') ?>">
            </div>

            <div class="col-md-2">
                <input name="jurusan"
                       class="form-control"
                       placeholder="Jurusan"
                       required
                       value="<?= e($edit['jurusan'] ?? '') ?>">
            </div>

            <div class="col-md-2">
                <input name="angkatan"
                       type="number"
                       class="form-control"
                       placeholder="Angkatan"
                       value="<?= e($edit['angkatan'] ?? date('Y')) ?>">
            </div>

        </div>

        <button class="btn btn-primary mt-3">
            Simpan
        </button>

        <?php if ($edit): ?>
            <a href="?page=mahasiswa"
               class="btn btn-secondary mt-3">Batal</a>
        <?php endif; ?>

    </form>

</div>

<form method="GET" class="mb-3 d-flex gap-2">

    <input type="hidden" name="page" value="mahasiswa">

    <input name="q"
           class="form-control"
           placeholder="Cari NIM, nama, jurusan..."
           value="<?= e($result['keyword']) ?>">

    <button class="btn btn-primary">Cari</button>

</form>

<div class="card p-3">

    <div class="table-responsive">

        <table class="table table-striped">

            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jurusan</th>
                    <th>Angkatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($result['data'] as $m): ?>

                <tr>

                    <td><?= e($m['nim']) ?></td>
                    <td><?= e($m['nama']) ?></td>
                    <td><?= e($m['email']) ?></td>
                    <td><?= e($m['jurusan']) ?></td>
                    <td><?= e($m['angkatan']) ?></td>

                    <td>
                        <a class="btn btn-warning btn-sm"
                           href="?page=mahasiswa&edit=<?= e($m['_id']) ?>">
                            Edit
                        </a>

                        <form method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus mahasiswa ini?')">

                            <input type="hidden" name="csrf_token"
                                   value="<?= e(csrf_token()) ?>">

                            <input type="hidden" name="delete_id"
                                   value="<?= e($m['_id']) ?>">

                            <button class="btn btn-danger btn-sm">
                                Hapus
                            </button>

                        </form>
                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <nav>
        <ul class="pagination">

            <?php for ($i = 1; $i <= $result['pages']; $i++): ?>

                <li class="page-item <?= $i == $result['page'] ? 'active' : '' ?>">

                    <a class="page-link"
                       href="?page=mahasiswa&p=<?= $i ?>&q=<?= urlencode($result['keyword']) ?>">

                        <?= $i ?>

                    </a>

                </li>

            <?php endfor; ?>

        </ul>
    </nav>

    <small>
        Total data: <?= e($result['total']) ?> mahasiswa
    </small>

</div>