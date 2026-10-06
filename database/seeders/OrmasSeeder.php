<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
use App\Models\Ormas;
use App\Models\Pengajuan;
use App\Models\Pengurus;
use Illuminate\Database\Seeder;

class OrmasSeeder extends Seeder
{
    public function run(): void
    {
        $ormasList = [
            [
                'nama_ormas' => 'Karang Taruna Muda Bersatu',
                'singkatan' => 'KTMB',
                'nomor_skt' => 'SKT/001/2022/JAKARTA',
                'tanggal_berdiri' => '2010-04-15',
                'bidang_kegiatan' => 'Kepemudaan',
                'visi' => 'Terwujudnya generasi muda yang berkarakter, berdaya, dan bermanfaat bagi masyarakat.',
                'misi' => 'Membangun jiwa kepemimpinan pemuda, mengembangkan potensi pemuda, dan menjadi wadah pemberdayaan generasi muda.',
                'alamat_sekretariat' => 'Jl. Pemuda No. 10',
                'kelurahan' => 'Cikini',
                'kecamatan' => 'Menteng',
                'kota' => 'Jakarta Pusat',
                'provinsi' => 'DKI Jakarta',
                'telepon' => '021-5678901',
                'email' => 'ktmb@gmail.com',
                'status' => 'aktif',
            ],
            [
                'nama_ormas' => 'Forum Kerukunan Umat Beragama',
                'singkatan' => 'FKUB',
                'nomor_skt' => 'SKT/002/2018/JAKARTA',
                'tanggal_berdiri' => '2005-08-17',
                'bidang_kegiatan' => 'Keagamaan',
                'visi' => 'Mewujudkan kerukunan antar umat beragama yang harmonis dan damai.',
                'misi' => 'Memfasilitasi dialog antar umat beragama dan mencegah konflik berbasis SARA.',
                'alamat_sekretariat' => 'Jl. Harmoni No. 5',
                'kecamatan' => 'Gambir',
                'kota' => 'Jakarta Pusat',
                'provinsi' => 'DKI Jakarta',
                'telepon' => '021-3456789',
                'status' => 'aktif',
            ],
            [
                'nama_ormas' => 'Lembaga Pemberdayaan Masyarakat Kota',
                'singkatan' => 'LPMK',
                'nomor_skt' => 'SKT/003/2020/BANDUNG',
                'tanggal_berdiri' => '2015-01-20',
                'bidang_kegiatan' => 'Sosial Kemasyarakatan',
                'visi' => 'Menjadi lembaga terdepan dalam pemberdayaan dan pengembangan masyarakat kota.',
                'misi' => 'Meningkatkan kapasitas masyarakat, mendorong partisipasi aktif warga dalam pembangunan.',
                'alamat_sekretariat' => 'Jl. Asia Afrika No. 21',
                'kecamatan' => 'Lengkong',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'telepon' => '022-7890123',
                'email' => 'lpmk.bandung@gmail.com',
                'status' => 'aktif',
            ],
            [
                'nama_ormas' => 'Himpunan Pengusaha Muda Indonesia',
                'singkatan' => 'HIPMI',
                'nomor_skt' => 'SKT/004/2019/SURABAYA',
                'tanggal_berdiri' => '1980-06-10',
                'bidang_kegiatan' => 'Ekonomi & Kewirausahaan',
                'visi' => 'Menjadi wadah pengusaha muda yang profesional dan berdaya saing tinggi.',
                'misi' => 'Mengembangkan jiwa kewirausahaan, membuka jaringan bisnis, dan mendorong pertumbuhan ekonomi lokal.',
                'alamat_sekretariat' => 'Jl. Pemuda No. 99',
                'kecamatan' => 'Gubeng',
                'kota' => 'Surabaya',
                'provinsi' => 'Jawa Timur',
                'telepon' => '031-5566778',
                'status' => 'aktif',
            ],
            [
                'nama_ormas' => 'Komunitas Peduli Lingkungan Nusantara',
                'singkatan' => 'KPLN',
                'nomor_skt' => 'SKT/005/2021/YOGYA',
                'tanggal_berdiri' => '2018-03-21',
                'bidang_kegiatan' => 'Lingkungan Hidup',
                'visi' => 'Indonesia yang bersih, hijau, dan berkelanjutan untuk generasi mendatang.',
                'misi' => 'Mengedukasi masyarakat tentang pentingnya menjaga lingkungan dan melaksanakan program penghijauan.',
                'alamat_sekretariat' => 'Jl. Kaliurang KM 5',
                'kecamatan' => 'Depok',
                'kota' => 'Yogyakarta',
                'provinsi' => 'DI Yogyakarta',
                'email' => 'kpln.jogja@gmail.com',
                'status' => 'aktif',
            ],
            [
                'nama_ormas' => 'Ikatan Perempuan Mandiri',
                'singkatan' => 'IPM',
                'nomor_skt' => 'SKT/006/2022/JAKARTA',
                'tanggal_berdiri' => '2012-12-01',
                'bidang_kegiatan' => 'Pemberdayaan Perempuan',
                'visi' => 'Perempuan Indonesia yang mandiri, berpengetahuan, dan berperan aktif dalam kehidupan bangsa.',
                'misi' => 'Meningkatkan kapasitas perempuan melalui pelatihan, pendidikan, dan advokasi hak-hak perempuan.',
                'alamat_sekretariat' => 'Jl. Kartini No. 8',
                'kecamatan' => 'Senen',
                'kota' => 'Jakarta Pusat',
                'provinsi' => 'DKI Jakarta',
                'telepon' => '021-9988776',
                'email' => 'ipm.jakarta@gmail.com',
                'status' => 'aktif',
            ],
        ];

        foreach ($ormasList as $data) {
            $ormas = Ormas::create($data);

            // Pengurus
            $pengurus = [
                ['nama' => 'Ahmad Fauzi', 'jabatan' => 'Ketua Umum'],
                ['nama' => 'Siti Nurhaliza', 'jabatan' => 'Sekretaris Umum'],
                ['nama' => 'Budi Santoso', 'jabatan' => 'Bendahara Umum'],
            ];
            foreach ($pengurus as $p) {
                Pengurus::create(array_merge($p, ['ormas_id' => $ormas->id]));
            }

            // Kegiatan
            Kegiatan::create([
                'ormas_id' => $ormas->id,
                'judul' => 'Bakti Sosial '.$ormas->singkatan,
                'deskripsi' => 'Kegiatan bakti sosial dan pembagian sembako kepada masyarakat yang membutuhkan di sekitar wilayah '.$ormas->kota.'. Kegiatan ini merupakan wujud kepedulian '.$ormas->nama_ormas.' terhadap sesama.',
                'tanggal_mulai' => now()->subDays(rand(5, 30))->format('Y-m-d'),
                'lokasi' => 'Balai Kelurahan '.($ormas->kelurahan ?? $ormas->kecamatan),
                'status' => 'selesai',
            ]);

            Kegiatan::create([
                'ormas_id' => $ormas->id,
                'judul' => 'Seminar & Workshop '.$ormas->bidang_kegiatan,
                'deskripsi' => 'Seminar dan workshop bertema '.$ormas->bidang_kegiatan.' yang akan dihadiri oleh para ahli dan praktisi. Kegiatan ini terbuka untuk umum dan tidak dipungut biaya.',
                'tanggal_mulai' => now()->addDays(rand(5, 20))->format('Y-m-d'),
                'lokasi' => 'Aula '.$ormas->kota,
                'status' => 'akan_datang',
            ]);
        }

        // Pengajuan contoh
        Pengajuan::create([
            'nama_pemohon' => 'Rizky Pratama',
            'nik' => '3171234567890001',
            'telepon' => '081234567890',
            'email' => 'rizky@gmail.com',
            'jenis_layanan' => 'pendaftaran_ormas',
            'keterangan' => 'Kami hendak mendaftarkan organisasi pemuda baru di wilayah Jakarta Selatan.',
            'status' => 'menunggu',
        ]);

        Pengajuan::create([
            'nama_pemohon' => 'Dewi Rahayu',
            'nik' => '3171234567890002',
            'telepon' => '082234567890',
            'email' => 'dewi@gmail.com',
            'jenis_layanan' => 'perpanjangan_skt',
            'ormas_id' => Ormas::first()->id,
            'keterangan' => 'SKT akan habis masa berlaku bulan depan.',
            'status' => 'diproses',
            'catatan_admin' => 'Dokumen sedang diverifikasi oleh tim.',
        ]);

        Pengajuan::create([
            'nama_pemohon' => 'Hendra Gunawan',
            'nik' => '3171234567890003',
            'telepon' => '083334567890',
            'email' => 'hendra@gmail.com',
            'jenis_layanan' => 'perubahan_data',
            'ormas_id' => Ormas::skip(1)->first()->id,
            'keterangan' => 'Perubahan susunan pengurus baru hasil musyawarah.',
            'status' => 'disetujui',
            'catatan_admin' => 'Perubahan data telah diverifikasi dan disetujui.',
        ]);
    }
}
