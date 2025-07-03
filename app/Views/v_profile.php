<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>History Transaksi Pembelian <strong><?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?></strong></h2>
<hr>
<div class="table-responsive">
    <table class="table datatable">
        <thead>
            <tr>
                <th>#</th>
                <th>ID Pembelian</th>
                <th>Waktu Pembelian</th>
                <th>Total Bayar</th>
                <th>Ongkir</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($buy)) : ?>
                <?php foreach ($buy as $index => $item) : ?>
                    <tr>
                        <th><?= $index + 1 ?></th>
                        <td><?= htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($item['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                        <td><?= number_to_currency($item['ongkir'], 'IDR') ?></td>
                        <td><?= htmlspecialchars($item['alamat'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= $item['status'] == "1" ? "Sudah Selesai" : "Belum Selesai" ?></td>
                        <td>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item['id'] ?>">
                                Detail
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data transaksi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<?php if (!empty($buy)) : ?>
    <?php foreach ($buy as $item) : ?>
        <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border rounded-3">
                    <div class="modal-header bg-light py-2 px-3">
                        <h6 class="modal-title mb-0">Detail Transaksi #<?= $item['id'] ?></h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body bg-white p-3">
                        <?php if (!empty($product[$item['id']])) : ?>
                            <?php foreach ($product[$item['id']] as $index2 => $item2) : ?>
                                <?php
                                    $harga = (int)$item2['harga'];
                                    $jumlah = (int)$item2['jumlah'];
                                    $subtotal = $harga * $jumlah;
                                ?>
                                <div class="d-flex mb-3 border-bottom pb-2">
                                    <div class="me-3">
                                        <?php if (!empty($item2['foto']) && file_exists("img/" . $item2['foto'])) : ?>
                                            <img src="<?= base_url("img/" . $item2['foto']) ?>" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                        <?php else : ?>
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px; font-size: 0.75rem;">No Img</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small"><?= $index2 + 1 ?>. <?= htmlspecialchars($item2['nama'], ENT_QUOTES, 'UTF-8') ?></div>
                                        <div class="small text-muted"><?= $jumlah ?> pcs</div>
                                        <div class="text-end small text-dark"><?= number_to_currency($subtotal, 'IDR') ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">Ongkir</span>
                                <span><?= number_to_currency($item['ongkir'], 'IDR') ?></span>
                            </div>
                            <div class="d-flex justify-content-between small fw-bold mt-1">
                                <span>Total</span>
                                <span><?= number_to_currency($item['total_harga'], 'IDR') ?></span>
                            </div>
                        <?php else : ?>
                            <p class="text-muted small">Detail produk tidak tersedia.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>





<?= $this->endSection() ?>
