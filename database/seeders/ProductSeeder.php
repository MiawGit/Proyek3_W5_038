<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'id_barang' => 'BRG001',
                'nama_barang' => 'Buku Tulis',
                'deskripsi' => 'Buku tulis bergaris untuk mencatat materi pelajaran.',
                'harga' => 5000,
                'stok' => 50,
                'gambar' => null,
            ],
            [
                'id_barang' => 'BRG002',
                'nama_barang' => 'Pulpen',
                'deskripsi' => 'Pulpen tinta biru untuk menulis sehari-hari.',
                'harga' => 3000,
                'stok' => 100,
                'gambar' => null,
            ],
            [
                'id_barang' => 'BRG003',
                'nama_barang' => 'Penggaris 30 cm',
                'deskripsi' => 'Penggaris plastik untuk mengukur dan membuat garis lurus.',
                'harga' => 4000,
                'stok' => 40,
                'gambar' => null,
            ],
            [
                'id_barang' => 'BRG004',
                'nama_barang' => 'Penghapus',
                'deskripsi' => 'Penghapus untuk menghapus tulisan pensil.',
                'harga' => 2000,
                'stok' => 60,
                'gambar' => null,
            ],
            [
                'id_barang' => 'BRG005',
                'nama_barang' => 'Pensil 2B',
                'deskripsi' => 'Pensil 2B untuk menulis, menggambar, dan ujian.',
                'harga' => 2500,
                'stok' => 80,
                'gambar' => null,
            ],
            [
                'id_barang' => 'BRG006',
                'nama_barang' => 'Rautan Pensil',
                'deskripsi' => 'Rautan untuk meruncingkan pensil.',
                'harga' => 3000,
                'stok' => 35,
                'gambar' => null,
            ],
            [
                'id_barang' => 'BRG007',
                'nama_barang' => 'Gunting Kecil',
                'deskripsi' => 'Gunting untuk kebutuhan tugas dan prakarya.',
                'harga' => 7000,
                'stok' => 25,
                'gambar' => null,
            ],
            [
                'id_barang' => 'BRG008',
                'nama_barang' => 'Lem Kertas',
                'deskripsi' => 'Lem untuk menempelkan kertas dan bahan prakarya.',
                'harga' => 5000,
                'stok' => 30,
                'gambar' => null,
            ],
            [
                'id_barang' => 'BRG009',
                'nama_barang' => 'Buku Catatan',
                'deskripsi' => 'Buku kecil untuk mencatat agenda dan catatan singkat.',
                'harga' => 8000,
                'stok' => 40,
                'gambar' => null,
            ],
            [
                'id_barang' => 'BRG010',
                'nama_barang' => 'Tempat Pensil',
                'deskripsi' => 'Tempat untuk menyimpan pulpen, pensil, dan alat tulis.',
                'harga' => 15000,
                'stok' => 20,
                'gambar' => null,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['id_barang' => $product['id_barang']],
                $product
            );
        }
    }
}