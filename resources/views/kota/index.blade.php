<!DOCTYPE html>
<html>
<head>
    <title>Data Kota</title>

    <!-- SELECT2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        .card {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            width: 400px;
        }

        .card h3 {
            margin-top: 0;
        }

        .btn {
            background: green;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        select, input {
            width: 100%;
            padding: 8px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h2>Tambah Kota</h2>

<input type="text" id="kotaInput" placeholder="Masukkan nama kota" required>
<br><br>
<button id="btnTambah" class="btn">Tambahkan</button>

<hr>

<!-- CARD 1 -->
<div class="card">
    <h3>Select</h3>

    <label>Select Kota:</label>
    <select id="selectKota"></select>

    <p>Kota Terpilih: <span id="hasil1"></span></p>
</div>

<!-- CARD 2 -->
<div class="card">
    <h3>Select 2</h3>

    <label>Select Kota:</label>
    <select id="selectKota2"></select>

    <p>Kota Terpilih: <span id="hasil2"></span></p>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<script src="assets/vendors/select2/select2.min.js"></script>
<script>

// INIT SELECT2
$('#selectKota2').select2();

document.getElementById("btnTambah").onclick = function(){

    let input = document.getElementById("kotaInput");

    // VALIDASI
    if(!input.value){
        alert("Kota harus diisi!");
        return;
    }

    let kota = input.value;

    // TAMBAH KE SELECT 1
    let option1 = new Option(kota, kota);
    document.getElementById("selectKota").add(option1);

    // TAMBAH KE SELECT2
    let option2 = new Option(kota, kota);
    $('#selectKota2').append(option2).trigger('change');

    input.value = "";
};


// SELECT BIASA
document.getElementById("selectKota").onchange = function(){
    document.getElementById("hasil1").innerText = this.value;
};


// SELECT2
$('#selectKota2').on('change', function(){
    $('#hasil2').text($(this).val());
});

</script>

</body>
</html>