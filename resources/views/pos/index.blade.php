@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-cart"></i>
        </span> Point of Sale
    </h3>
</div>

<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-4">
                        <label>ID Barang</label>
                        <input type="text" id="kode" class="form-control border-primary" placeholder="Ketik ID + Enter">
                    </div>
                    <div class="col-4">
                        <label>Nama Barang</label>
                        <input type="text" id="nama" class="form-control" placeholder="Terisi Otomatis" readonly>
                    </div>
                    <div class="col-2">
                        <label>Harga</label>
                        <input type="text" id="harga" class="form-control" placeholder="0" readonly>
                    </div>
                    <div class="col-2">
                        <label>Qty</label>
                        <input type="number" id="jumlah" class="form-control" value="1" min="1">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" id="posTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Barang</th>
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
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <button id="tambahBtn" class="btn btn-gradient-info btn-block w-100 mb-3" disabled>
                        <i class="mdi mdi-plus"></i> Tambahkan ke List
                    </button>
                    <hr>
                    <div class="py-4 text-center">
                        <p class="text-muted mb-1">Total Pembayaran</p>
                        <h1 class="display-4 font-weight-bold text-primary">Rp <span id="totalDisplay">0</span></h1>
                    </div>
                </div>
                
                <button id="bayarBtn" class="btn btn-gradient-primary btn-lg w-100">
                    <i class="mdi mdi-cash-multiple"></i> PROSES BAYAR
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Memastikan Library SweetAlert dan Axios terload --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
const kodeInput = document.getElementById('kode');
const namaInput = document.getElementById('nama');
const hargaInput = document.getElementById('harga');
const jumlahInput = document.getElementById('jumlah');
const tambahBtn = document.getElementById('tambahBtn');
const totalDisplay = document.getElementById('totalDisplay');

let cart = [];

// 1. Ambil data barang ketika Enter ditekan di kolom ID
kodeInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        let id = this.value;
        if(!id) return;

        axios.get('/barang-get/' + id)
        .then(res => {
            if (res.data) {
                // REVISI: Menggunakan res.data.nama sesuai kolom database kamu
                namaInput.value = res.data.nama; 
                hargaInput.value = res.data.harga;
                jumlahInput.value = 1;
                tambahBtn.disabled = false;
                jumlahInput.focus();
            } else {
                Swal.fire('Oops!', 'Barang dengan ID ' + id + ' tidak ditemukan.', 'error');
                resetInput();
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'Gagal terhubung ke server', 'error');
        });
    }
});

function resetInput() {
    kodeInput.value = '';
    namaInput.value = '';
    hargaInput.value = '';
    tambahBtn.disabled = true;
    kodeInput.focus();
}

// 2. Tambahkan barang ke tabel list (keranjang)
tambahBtn.onclick = function() {
    let kode = kodeInput.value;
    let nama = namaInput.value;
    let harga = parseInt(hargaInput.value);
    let jumlah = parseInt(jumlahInput.value);

    let itemExist = cart.find(i => i.kode === kode);
    if (itemExist) {
        itemExist.jumlah += jumlah;
        itemExist.subtotal = itemExist.jumlah * harga;
    } else {
        cart.push({ 
            kode: kode, 
            nama: nama, 
            harga: harga, 
            jumlah: jumlah, 
            subtotal: harga * jumlah 
        });
    }

    resetInput();
    render();
};

// 3. Fungsi untuk memperbarui tampilan tabel
function render() {
    let html = '';
    let total = 0;

    cart.forEach((item, i) => {
        total += item.subtotal;
        html += `
        <tr>
            <td>${item.kode}</td>
            <td class="font-weight-bold">${item.nama}</td>
            <td>Rp ${parseInt(item.harga).toLocaleString('id-ID')}</td>
            <td>
                <input type="number" class="form-control form-control-sm" value="${item.jumlah}" 
                style="width:70px" onchange="updateQty(${i}, this.value)">
            </td>
            <td class="text-primary font-weight-bold">Rp ${item.subtotal.toLocaleString('id-ID')}</td>
            <td>
                <button class="btn btn-inverse-danger btn-icon btn-sm" onclick="hapus(${i})">
                    <i class="mdi mdi-delete"></i>
                </button>
            </td>
        </tr>`;
    });

    if(cart.length === 0) {
        html = '<tr><td colspan="6" class="text-center text-muted">Belum ada barang ditambahkan</td></tr>';
    }

    document.querySelector('#posTable tbody').innerHTML = html;
    totalDisplay.innerText = total.toLocaleString('id-ID');
}

// Fungsi global agar bisa dipanggil dari atribut onclick di string HTML
window.updateQty = (i, val) => {
    if(val < 1) val = 1;
    cart[i].jumlah = parseInt(val);
    cart[i].subtotal = cart[i].jumlah * cart[i].harga;
    render();
}

window.hapus = (i) => {
    cart.splice(i, 1);
    render();
}

// 4. Proses Pembayaran
document.getElementById('bayarBtn').onclick = function() {
    if (cart.length === 0) {
        return Swal.fire('Peringatan', 'Keranjang belanja masih kosong!', 'warning');
    }

    Swal.fire({
        title: 'Konfirmasi Pembayaran',
        text: "Proses transaksi sebesar Rp " + totalDisplay.innerText + "?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#b66dff',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Bayar sekarang!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Hilangkan titik ribuan sebelum kirim ke server
            let totalRaw = totalDisplay.innerText.replace(/\./g, '');
            
            axios.post('/bayar', {
                items: cart,
                total: totalRaw
            })
            .then(res => {
                Swal.fire('Sukses!', 'Transaksi berhasil disimpan ke database.', 'success');
                cart = [];
                render();
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Gagal', 'Terjadi kesalahan sistem saat menyimpan transaksi.', 'error');
            });
        }
    });
}

// Inisialisasi tampilan awal
render();
</script>
@endsection