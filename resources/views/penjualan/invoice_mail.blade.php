<h3>Invoice</h3>
Tanggal : <?=date('Y-m-d',strtotime($data['created_at'])); ?><br/>
Name : <?= $data['nama']; ?><br />
Email : <?= $data['email']; ?><br />
Phone : <?= $data['telepon']; ?><br />
Kendaraan : <?= $data['kendaraan']; ?>
