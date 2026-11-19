<div class="card p-3 mb-3">

    <h5>Tambah KRS</h5>

    <form method="POST">

        <input type="hidden" name="csrf_token"
               value="<?= e(csrf_token()) ?>">

        <div class="row g-2">

            <div class="col-md-4">
                <label>Mahasiswa</label>

                <select name="mahasiswa_id" class="form-select" required>

                    <option value="">Pilih Mahasiswa</option>

                    <?php foreach ($students as $s): ?>

                        <option value="<?= e($s['_id']) ?>">
                            <?= e($s['nim'] . ' - ' . $s['nama']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>

            <div class="col-md-4">
                <label>Mata Kuliah</label>

                <select name="matakuliah_id" class="form-select" required>

                    <option value="">Pilih Mata Kuliah</option>

                    <?php foreach ($courses as $c): ?>

                        <option value="<?= e($c['_id']) ?>">
                            <?= e($c['kode'] . ' - ' . $c['nama']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>

            <div class="col-md-4">
                <label>Semester</label>

                <input name="semester"
                       class="form-control"
                       placeholder="Contoh: 2026-Ganjil"
                       required>
            </div>

        </div>

        <button class="btn btn-primary mt-3">Simpan KRS</button>

    </form>

</div>

<div class="card p-3">

    <h5>Daftar KRS</h5>

    <table class="table table-striped">

        <tr>
            <th>Mahasiswa</th>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Aksi</th>
        </tr>

        <?php foreach ($rows as $r): ?>

        <tr>
            <td><?= e($r['nama_mahasiswa']) ?></td>
            <td><?= e($r['nama_matakuliah']) ?></td>
            <td><?= e($r['sks']) ?></td>
            <td><?= e($r['semester']) ?></td>
            <td>

                <form method="POST"
                      onsubmit="return confirm('Hapus KRS?')">

                    <input type="hidden" name="csrf_token"
                           value="<?= e(csrf_token()) ?>">

                    <input type="hidden" name="delete_id"
                           value="<?= e($r['_id']) ?>">

                    <button class="btn btn-danger btn-sm">
                        Hapus
                    </button>

                </form>

            </td>
        </tr>

        <?php endforeach; ?>

    </table>

</div>