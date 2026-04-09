<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern POS System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        :root {
            --primary: #6366f1;
            --bg: #f8fafc;
            --card: #ffffff;
            --text: #1e293b;
            --border: #e2e8f0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 20px;
        }

        /* Container Utama */
        .pos-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 350px; /* Tabel kiri, Ringkasan kanan */
            gap: 20px;
        }

        /* Panel Kiri */
        .main-panel {
            background: var(--card);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* Baris Input Atas */
        .input-row {
            display: grid;
            grid-template-columns: 1.5fr 1.5fr 1fr 80px;
            gap: 10px;
            margin-bottom: 20px;
        }

        input {
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;
            width: 100%;
            box-sizing: border-box; /* Biar padding gak ngerusak lebar */
        }

        input:focus { border-color: var(--primary); }
        input[readonly] { background: #f1f5f9; cursor: not-allowed; }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid var(--border);
            color: #64748b;
            font-size: 13px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
        }

        /* Panel Kanan (Sidebar) */
        .sidebar {
            background: var(--card);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .total-box {
            margin-bottom: 20px;
        }

        .total-label { font-size: 14px; color: #64748b; }
        .total-price { 
            display: block; 
            font-size: 32px; 
            font-weight: 700; 
            color: var(--primary); 
        }

        /* Tombol-Tombol */
        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        #tambahBtn {
            background: var(--primary);
            color: white;
            margin-bottom: 10px;
        }

        #tambahBtn:disabled { background: #cbd5e1; cursor: not-allowed; }

        #bayarBtn {
            background: #10b981;
            color: white;
            font-size: 16px;
        }

        .btn-hapus {
            background: #fee2e2;
            color: #ef4444;
            padding: 5px 10px;
            width: auto;
        }

        .btn-hapus:hover { background: #ef4444; color: white; }

        @media (max-width: 900px) {
            .pos-container { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="pos-container">
    <div class="main-panel">
        <h2 style="margin-top:0">Point of Sale</h2>
        
        <div class="input-row">
            <input type="text" id="kode" placeholder="Kode Barang + Enter">
            <input type="text" id="nama" placeholder="Nama Barang" readonly>
            <input type="text" id="harga" placeholder="Harga" readonly>
            <input type="number" id="jumlah" value="1">
        </div>

        <table id="table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>
    </div>

    <div class="sidebar">
        <button id="tambahBtn" disabled>Tambahkan ke List</button>
        <hr style="border:0; border-top:1px solid var(--border); margin: 20px 0;">
        
        <div class="total-box">
            <span class="total-label">Total Pembayaran</span>
            <span class="total-price">Rp <span id="total">0</span></span>
        </div>

        <button id="bayarBtn">Proses Bayar</button>
    </div>
</div>

<script>
// Pastikan ID ini sesuai dengan yang ada di HTML
const kodeInput = document.getElementById('kode');
const namaInput = document.getElementById('nama');
const hargaInput = document.getElementById('harga');
const jumlahInput = document.getElementById('jumlah');
const tambahBtn = document.getElementById('tambahBtn');
const totalSpan = document.getElementById('total');

let cart = [];

// ENTER ambil barang
kodeInput.addEventListener('keypress', function(e){
    if(e.key === 'Enter'){
        axios.get('/barang/' + this.value)
        .then(res => {
            if(res.data){
                namaInput.value = res.data.nama;
                hargaInput.value = res.data.harga;
                jumlahInput.value = 1;
                tambahBtn.disabled = false;
            } else {
                Swal.fire('Oops', 'Barang tidak ditemukan', 'error');
            }
        })
        .catch(err => console.error("Gagal ambil data"));
    }
});

// TAMBAH
tambahBtn.onclick = function(){
    let kode = kodeInput.value;
    let nama = namaInput.value;
    let harga = parseInt(hargaInput.value);
    let jumlah = parseInt(jumlahInput.value);

    let found = cart.find(i => i.kode === kode);

    if(found){
        found.jumlah += jumlah;
        found.subtotal = found.jumlah * harga;
    } else {
        cart.push({
            kode, nama, harga, jumlah,
            subtotal: harga * jumlah
        });
    }

    // Reset input setelah tambah
    kodeInput.value = '';
    namaInput.value = '';
    hargaInput.value = '';
    tambahBtn.disabled = true;

    render();
};

function render(){
    let html = '';
    let total = 0;

    cart.forEach((item, i) => {
        total += item.subtotal;
        html += `
        <tr>
            <td>${item.kode}</td>
            <td>${item.nama}</td>
            <td>${item.harga.toLocaleString()}</td>
            <td>
                <input type="number" class="qty-table" value="${item.jumlah}" 
                style="width:50px" onchange="updateJumlah(${i}, this.value)">
            </td>
            <td>${item.subtotal.toLocaleString()}</td>
            <td><button class="btn-hapus" onclick="hapus(${i})">X</button></td>
        </tr>
        `;
    });

    document.querySelector('#table tbody').innerHTML = html;
    totalSpan.innerText = total.toLocaleString();
}

function updateJumlah(i, val){
    cart[i].jumlah = parseInt(val);
    cart[i].subtotal = cart[i].jumlah * cart[i].harga;
    render();
}

function hapus(i){
    cart.splice(i,1);
    render();
}

document.getElementById('bayarBtn').onclick = function(){
    if(cart.length === 0) return Swal.fire('Kosong', 'Pilih barang dulu!', 'warning');

    let btn = this;
    btn.disabled = true;
    btn.innerHTML = 'Loading...';

    axios.post('/bayar', {
        items: cart,
        total: totalSpan.innerText.replace(/,/g, '') // Hapus koma format angka
    })
    .then(res => {
        Swal.fire('Sukses', 'Transaksi berhasil', 'success');
        cart = [];
        render();
        btn.disabled = false;
        btn.innerHTML = 'Proses Bayar';
    });
}
</script>
</body>
</html>