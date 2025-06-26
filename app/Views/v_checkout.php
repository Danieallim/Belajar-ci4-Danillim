<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <!-- Kolom Kiri: Form -->
        <div class="col-lg-6">
            <h3>Checkout</h3>
            <?= form_open('buy', 'class="row g-3"') ?>
            <?= form_hidden('username', session()->get('username')) ?>
            <?= form_input(['type' => 'hidden', 'name' => 'total_harga', 'id' => 'total_harga', 'value' => '']) ?>

            <!-- Input Nama -->
            <div class="col-12">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" value="<?= session()->get('username'); ?>" readonly>
            </div>

            <!-- Input Alamat -->
            <div class="col-12">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat">
            </div>

            <!-- Dropdown Kelurahan -->
            <div class="col-12">
                <label for="kelurahan" class="form-label">Kelurahan</label>
                <select class="form-control" id="kelurahan" name="kelurahan" required></select>
            </div>

            <!-- Dropdown Layanan -->
            <div class="col-12">
                <label for="layanan" class="form-label">Layanan</label>
                <select class="form-control" id="layanan" name="layanan" required></select>
            </div>

            <!-- Ongkir -->
            <div class="col-12">
                <label for="ongkir" class="form-label">Ongkir</label>
                <input type="text" class="form-control" id="ongkir" name="ongkir" readonly>
            </div>
        </div>

        <!-- Kolom Kanan: Tabel Order -->
        <div class="col-lg-6">
            <h3>Order Summary</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if (!empty($items)) :
                        foreach ($items as $index => $item) :
                    ?>
                            <tr>
                                <td><?php echo $item['name'] ?></td>
                                <td><?php echo number_to_currency($item['price'], 'IDR') ?></td>
                                <td><?php echo $item['qty'] ?></td>
                                <td><?php echo number_to_currency($item['price'] * $item['qty'], 'IDR') ?></td>
                            </tr>
                    <?php
                        endforeach;
                    endif;
                    ?>
                    <tr>
                        <td colspan="2"></td>
                        <td>Subtotal</td>
                        <td><?php echo number_to_currency($total, 'IDR') ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td>Total</td>
                        <td><span id="total"><?php echo number_to_currency($total, 'IDR') ?></span></td>
                    </tr>
                </tbody>
            </table>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Buat Pesanan</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
// Javascript untuk mengisi dropdown kelurahan dan layanan secara dinamis
$(document).ready(function() {
    var ongkir = 0;
    var total = 0;
    hitungTotal();

    $('#kelurahan').select2({
        placeholder: 'Ketik nama kelurahan...',
        ajax: {
            url: '<?= base_url('get-location') ?>',
            dataType: 'json',
            delay: 1500,
            data: function (params) {
                return {
                    search: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.id,
                            text: item.subdistrict_name + ", " + item.district_name + ", " + item.city_name + ", " + item.province_name + ", " + item.zip_code
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 3
    });

    $("#kelurahan").on('change', function() {
        var id_kelurahan = $(this).val(); 
        $("#layanan").empty();
        ongkir = 0;

        $.ajax({
            url: "<?= site_url('get-cost') ?>",
            type: 'GET',
            data: { 
                'destination': id_kelurahan, 
            },
            dataType: 'json',
            success: function(data) { 
                data.forEach(function(item) {
                    var text = item["description"] + " (" + item["service"] + ") : estimasi " + item["etd"];
                    $("#layanan").append($('<option>', {
                        value: item["cost"],
                        text: text 
                    }));
                });
                hitungTotal();
            },
        });
    });

    $("#layanan").on('change', function() {
        ongkir = parseInt($(this).val());
        hitungTotal();
    });

    // Fungsi untuk menghitung total harga (produk + ongkir)
    function hitungTotal() {
        total = ongkir + <?= $total ?>;
        $("#ongkir").val(ongkir);
        $("#total").html("IDR " + total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
        $("#total_harga").val(total);
    }
});
</script>
<?= $this->endSection() ?>
