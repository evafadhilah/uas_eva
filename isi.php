<?php

if (isset($_POST['submit'])) {
    // Collect POST data
    $no = $_POST['no'];
    $nama = $_POST['name'];
    $unit = $_POST['unit'];
    $gajiDate = $_POST['tanggal_gaji'];
    $jabatan = $_POST['jabatan']; 
    $lamaKerja = $_POST['lama_kerja'];
    $statusKerja = $_POST['status'];
    $bpjs = isset($_POST['bpjs']) ? $_POST['bpjs'] : 0;
    $pinjaman = isset($_POST['pinjaman']) ? $_POST['pinjaman'] : 0;
    $tabungan = isset($_POST['tabungan']) ? $_POST['tabungan'] : 0;  
    $lainnya = isset($_POST['lainnya']) ? $_POST['lainnya'] : 0;

    // objek
    $gajiObj = new Gaji($no, $nama, $unit, $gajiDate, $jabatan, $lamaKerja, $statusKerja, $bpjs, $pinjaman, $tabungan, $lainnya);
    
    // hitung rincian gaji
    $salaryDetails = $gajiObj->calculateSalary();
    $gajiObj->displaySalaryDetails($salaryDetails);
}

class Gaji {
    public $no;
    public $nama;
    public $unit;
    public $gajiDate;
    public $jabatan;
    public $lamaKerja;
    public $statusKerja;
    public $bpjs;
    public $pinjaman;
    public $tabungan;
    public $lainnya;
    public $gaji;

    // Constructor to initialize the object with user data
    public function __construct($no, $nama, $unit, $gajiDate, $jabatan, $lamaKerja, $statusKerja, $bpjs, $pinjaman, $tabungan, $lainnya) {
        $this->no = $no;
        $this->nama = $nama;
        $this->unit = $unit;
        $this->gajiDate = $gajiDate;
        $this->jabatan = $jabatan;
        $this->lamaKerja = $lamaKerja;
        $this->statusKerja = $statusKerja;
        $this->bpjs = $bpjs;
        $this->pinjaman = $pinjaman;
        $this->tabungan = $tabungan;
        $this->lainnya = $lainnya;
}

// Method to calculate salary based on input data
public function calculateSalary() {
// Base salary based on Jabatan
switch ($this->jabatan) {
    case "kepala sekolah":
        $this->gaji = 1000000;
        break;
    case "wakasek":
        $this->gaji = 7500000;
        break;
    case "guru":
        $this->gaji = 5000000;
        break;
    case "ob":
        $this->gaji = 2500000;
        break;
    default:
        $this->gaji = 0;
        break;
}

// Tunjangan based on Lama Kerja
$tunjangan = ($this->lamaKerja >= 5) ? 1000000 : 0;

// Bonus based on Status Kerja
$bonus = ($this->statusKerja == "tetap") ? 500000 : 0;

// Calculate total deductions (BPJS + Pinjaman + Tabungan + Lainnya)
$totalPotongan = $this->bpjs + $this->pinjaman + $this->tabungan + $this->lainnya;

// Gaji Bersih = Gaji + Bonus - (BPJS + Pinjaman + Tabungan + Lainnya)
$gajiBersih = $this->gaji + $bonus - $totalPotongan;

// Return an array of the calculated values
return [
    'gaji' => $this->gaji,
    'tunjangan' => $tunjangan,
    'bonus' => $bonus,
    'totalPotongan' => $totalPotongan,
    'gajiBersih' => $gajiBersih
];
}

// Method to display the salary details
public function displaySalaryDetails($salaryDetails) {
echo "<h3>STRUK GAJI</h3>";
echo "<table class='table table-bordered'>";
echo "<tr><td>No</td><td>: {$this->no}</td></tr>";
echo "<tr><td>Nama</td><td>: {$this->nama}</td></tr>";
echo "<tr><td>Unit Pendidikan</td><td>: {$this->unit}</td></tr>";
echo "<tr><td>Tanggal Gaji</td><td>: {$this->gajiDate}</td></tr>";
echo "<tr><td>Jabatan</td><td>: {$this->jabatan}</td></tr>";
echo "<tr><td>Gaji</td><td>: {$salaryDetails['gaji']}</td></tr>";
echo "<tr><td>Lama Kerja</td><td>: {$this->lamaKerja}</td></tr>";
echo "<tr><td>Tunjangan</td><td>: {$salaryDetails['tunjangan']}</td></tr>";
echo "<tr><td>Status Kerja</td><td>: {$this->statusKerja}</td></tr>";
echo "<tr><td>Bonus</td><td>: {$salaryDetails['bonus']}</td></tr>";
echo "<tr><td>Gaji Bersih</td><td>: " . ($salaryDetails['gaji'] + $salaryDetails['bonus']) . "</td></tr>";
echo "<tr><td>Total Potongan</td><td>: {$salaryDetails['totalPotongan']}</td></tr>";
echo "<tr><td><b>Gaji Bersih</b></td><td>: {$salaryDetails['gajiBersih']}</td></tr>";
echo "</table>";
}
}
?>








