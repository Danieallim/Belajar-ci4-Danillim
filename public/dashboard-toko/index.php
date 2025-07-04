<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <?php 
    function curl(){ 
        $curl = curl_init(); 
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost:8080/api",
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_CUSTOMREQUEST => "GET", 
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: random123678abcghi",
            ),
        ));
            
        $output = curl_exec($curl); 	
        curl_close($curl);      
        
        $data = json_decode($output);   
        
        return $data;
    } 
    ?>
    <div class="p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis">Dashboard - TOKO</h1>
        <p class="fs-5 text-body-secondary"><?= date("l, d-m-Y") ?> 
        <span id="jam"></span>:<span id="menit"></span>:<span id="detik"></span></p>
    </div> 
    <hr>

    <div class="table-responsive card m-5 p-5">
        <table class="table text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Alamat</th>
                    <th>Total Harga</th>
                    <th>Ongkir</th>
                    <th>Status</th>
                    <th>Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $send1 = curl();

                    if(!empty($send1) && $send1->status->code == 200){
                        $hasil1 = $send1->results;
                        $i = 1; 

                        foreach($hasil1 as $item1){ 
                            // Badge warna status
                            $badge = 'secondary';
                            switch ($item1->status) {
                                case 'Diproses': $badge = 'warning'; break;
                                case 'Dikirim': $badge = 'info'; break;
                                case 'Selesai': $badge = 'success'; break;
                                case 'Dibatalkan': $badge = 'danger'; break;
                            }
                            ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $item1->username; ?></td>
                                <td><?= $item1->alamat; ?></td>
                                <td>Rp<?= number_format($item1->total_harga, 0, ',', '.'); ?></td>
                                <td>Rp<?= number_format($item1->ongkir, 0, ',', '.'); ?></td>
                                <td><span class="badge bg-<?= $badge ?>"><?= $item1->status; ?></span></td>
                                <td><?= $item1->tanggal_transaksi; ?></td>
                            </tr> 
                            <?php
                        } 
                    } else {
                        echo '<tr><td colspan="7">Tidak ada data atau API Key salah</td></tr>';
                    }
                ?> 
            </tbody>
        </table>
    </div> 
  </body>
</html>
