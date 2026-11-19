<div class="card p-3 mb-3">

    <h5>Tambah Dosen</h5>

    <form method="POST">

        <input type="hidden" name="csrf_token"
               value="<?= e(csrf_token()) ?>">

        <div class="row g-2">

            <div class="col-md-3">
                <input name="nidn" class="form-control"
                       placeholder="NIDN" required>
            </div>

            <div class="col-md-3">
                <input name="nama" class="form-control"
                       placeholder="Nama Dosen" required>
            </div>

            <div class="col-md-3">
                <input name="email" type="email"
                       class="form-control" placeholder="Email" required>
            </div>

            <div class="col-md-3">
                <input name="program_studi" class="form-control"
                       placeholder="Program Studi" required>
            </div>

        </div>

        <button class="btn btn-primary mt-3">Simpan</button>

    </form>

</div>

<div class="card p-3">

    <table class="table table-striped">

        <tr>
            <th>NIDN</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Program Studi</th>
            <th>Aksi</th>
        </tr>

        <?php foreach ($rows as $d): ?>

        <tr>
            <td><?= e($d['nidn']) ?></td>
            <td><?= e($d['nama']) ?></td>
            <td><?= e($d['email']) ?></td>
            <td><?= e($d['program_studi']) ?></td>
            <td>
                <form method="POST"
                      onsubmit="return confirm('Hapus dosen?')">

                    <input type="hidden" name="csrf_token"
                           value="<?= e(csrf_token()) ?>">

                    <input type="hidden" name="delete_id"
                           value="<?= e($d['_id']) ?>">

                    <button class="btn btn-danger btn-sm">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>

        <?php endforeach; ?>

    </table>

</div>