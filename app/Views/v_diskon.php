<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- Flashdata Notifikasi -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('failed')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('failed') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Info Diskon Hari Ini -->
<?php if (!empty($diskon_hari_ini)) : ?>
    <div class="alert alert-success">
        Hari ini ada diskon <strong>Rp <?= number_format($diskon_hari_ini['nominal'], 0, ',', '.') ?></strong> per item.
    </div>
<?php endif; ?>

<!-- Judul dan Tombol Tambah -->
<h5 class="mb-3">Manajemen Diskon</h5>
<div class="mb-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        Tambah Data
    </button>
</div>

<!-- Tabel Diskon -->
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>Nominal (Rp)</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($diskon as $i => $d) : ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= $d['tanggal'] ?></td>
                <td><?= number_format($d['nominal'], 0, ',', '.') ?></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $d['id'] ?>">Ubah</button>
                    <a href="<?= base_url('diskon/delete/' . $d['id']) ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus diskon ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal Tambah Diskon -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('diskon/store') ?>" method="post" class="modal-content">
            <?= csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Diskon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required value="<?= old('tanggal') ?>">
                </div>
                <div class="mb-3">
                    <label for="nominal" class="form-label">Nominal</label>
                    <input type="number" name="nominal" id="nominal" class="form-control" required value="<?= old('nominal') ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Diskon -->
<?php foreach ($diskon as $d) : ?>
    <div class="modal fade" id="modalEdit<?= $d['id'] ?>" tabindex="-1" aria-labelledby="modalEditLabel<?= $d['id'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <form action="<?= base_url('diskon/update/' . $d['id']) ?>" method="post" class="modal-content">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel<?= $d['id'] ?>">Edit Diskon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal-<?= $d['id'] ?>" class="form-label">Tanggal</label>
                        <input type="date" id="tanggal-<?= $d['id'] ?>" name="tanggal" class="form-control" value="<?= $d['tanggal'] ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nominal-<?= $d['id'] ?>" class="form-label">Nominal</label>
                        <input type="number" id="nominal-<?= $d['id'] ?>" name="nominal" class="form-control" value="<?= $d['nominal'] ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<?= $this->endSection() ?>
