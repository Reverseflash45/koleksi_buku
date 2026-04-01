<!DOCTYPE html>
<html>
<head>
    <title>CRUD Barang</title>

    <style>
        body { font-family: Arial; padding: 20px; }

        table {
            border-collapse: collapse;
            margin-top: 20px;
            width: 60%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        tr:hover {
            cursor: pointer;
            background: #f2f2f2;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            color: white;
            cursor: pointer;
        }

        .btn-green { background: green; }
        .btn-red { background: red; }

        .spinner { display: none; }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .modal-content {
            background: white;
            padding: 20px;
            margin: 10% auto;
            width: 300px;
        }
    </style>
</head>
<body>

<h2>Tambah Barang</h2>

<form id="formBarang">
    Nama:<br>
    <input type="text" id="nama" required><br><br>

    Harga:<br>
    <input type="number" id="harga" required><br><br>
</form>

<button type="button" id="btnSubmit" class="btn btn-green">Submit</button>
<span id="spinner" class="spinner">⏳ Loading...</span>

<hr>

<h3>Data Barang</h3>

<table id="tableBarang">
<thead>
<tr>
<th>ID</th>
<th>Nama</th>
<th>Harga</th>
</tr>
</thead>
<tbody></tbody>
</table>

<!-- MODAL -->
<div class="modal" id="modal">
    <div class="modal-content">

        <form id="formEdit">

            ID:<br>
            <input type="text" id="editId" readonly><br><br>

            Nama:<br>
            <input type="text" id="editNama" required><br><br>

            Harga:<br>
            <input type="number" id="editHarga" required><br><br>

        </form>

        <button id="btnHapus" class="btn btn-red">Hapus</button>
        <button id="btnUbah" class="btn btn-green">Ubah</button>
        <span id="spinnerEdit" class="spinner">⏳</span>

    </div>
</div>

<script>

let idCounter = 1;
let selectedRow = null;

/* ================= TAMBAH ================= */
document.getElementById("btnSubmit").onclick = function(){

    let form = document.getElementById("formBarang");

    if(!form.checkValidity()){
        form.reportValidity();
        return;
    }

    let btn = this;
    let spinner = document.getElementById("spinner");

    btn.style.display = "none";
    spinner.style.display = "inline";

    setTimeout(() => {

        let nama = document.getElementById("nama").value;
        let harga = document.getElementById("harga").value;

        let table = document.querySelector("#tableBarang tbody");
        let row = table.insertRow();

        row.insertCell(0).innerHTML = idCounter++;
        row.insertCell(1).innerHTML = nama;
        row.insertCell(2).innerHTML = "Rp " + Number(harga).toLocaleString();

        // klik row → buka modal
        row.onclick = function(){
            selectedRow = this;

            document.getElementById("editId").value = this.cells[0].innerText;
            document.getElementById("editNama").value = this.cells[1].innerText;
            document.getElementById("editHarga").value =
                this.cells[2].innerText.replace(/[^\d]/g, '');

            document.getElementById("modal").style.display = "block";
        };

        form.reset();
        btn.style.display = "inline";
        spinner.style.display = "none";

    }, 800);
};


/* ================= HAPUS ================= */
document.getElementById("btnHapus").onclick = function(){

    if(selectedRow){
        selectedRow.remove();
        document.getElementById("modal").style.display = "none";
    }

};


/* ================= UPDATE ================= */
document.getElementById("btnUbah").onclick = function(){

    let form = document.getElementById("formEdit");

    if(!form.checkValidity()){
        form.reportValidity();
        return;
    }

    let spinner = document.getElementById("spinnerEdit");
    spinner.style.display = "inline";

    setTimeout(() => {

        let nama = document.getElementById("editNama").value;
        let harga = document.getElementById("editHarga").value;

        selectedRow.cells[1].innerHTML = nama;
        selectedRow.cells[2].innerHTML = "Rp " + Number(harga).toLocaleString();

        spinner.style.display = "none";
        document.getElementById("modal").style.display = "none";

    }, 800);
};


/* ================= CLOSE MODAL ================= */
window.onclick = function(e){
    let modal = document.getElementById("modal");
    if(e.target == modal){
        modal.style.display = "none";
    }
};

</script>

</body>
</html>