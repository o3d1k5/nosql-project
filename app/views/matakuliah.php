<div class="card p-3 mb-3">

    <h5>Tambah Mata Kuliah</h5>

    <form method="POST">

        <input type="hidden" name="csrf_token"
               value="<?= e(csrf_token()) ?>">

        <div class="row g-2">

            <div class="col-md-3">
                <input name="kode" class="form-control"
                       placeholder="Kode MK" required>
            </div>

            <div class="col-md-4">
                <input name="nama" class="form-control"
                       placeholder="Nama Mata Kuliah" required>
            </div>

            <div class="col-md-2">
                <input name="sks" type="number" min="1" max="6"
                       class="form-control" placeholder="SKS" required>
            </div>

            <div class="col-md-3">
                <input name="semester" type="number" min="1" max="14"
                       class="form-control" placeholder="Semester" required>
            </div>

        </div>

        <button class="btn btn-primary mt-3">Simpan</button>

    </form>

</div>

<div class="card p-3">

    <table class="table table-striped">

        <tr>
            <th>Kode</th>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Aksi</th>
        </tr>

        <?php foreach ($rows as $m): ?>

        <tr>
            <td><?= e($m['kode']) ?></td>
            <td><?= e($m['nama']) ?></td>
            <td><?= e($m['sks']) ?></td>
            <td><?= e($m['semester']) ?></td>
            <td>

                <form method="POST"
                      onsubmit="return confirm('Hapus mata kuliah?')">

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

    </table>

</div>