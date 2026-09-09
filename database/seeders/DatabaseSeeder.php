<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\Question;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Intern Demo
        User::firstOrCreate(
            ['email' => 'intern@hotel.com'],
            [
                'name' => 'Daniel Christian (Intern)',
                'password' => Hash::make('password'),
                'role' => 'intern',
            ]
        );

        // ==========================================
        // KATEGORI A: HOTEL ONBOARDING
        // ==========================================

        // Modul 1: Marriott History & Core Values
        $mod1 = Module::create([
            'title' => 'Marriott History & Core Values',
            'slug' => Str::slug('Marriott History & Core Values'),
            'Description' => 'Ringkasan sejarah berdirinya Marriott International sejak 1927 dan 5 Nilai Utama perusahaan.',
            'content' => '<h2>Sejarah Marriott International</h2>
<p>Marriott International berawal dari sebuah kedai minuman A&W Root Beer kecil berkapasitas 9 kursi di Washington, D.C., yang dibuka oleh <strong>J. Willard Marriott</strong> dan istrinya, Alice Marriott, pada Mei 1927. Bisnis ini kemudian berkembang menjadi jaringan restoran Hot Shoppes sebelum merambah ke industri perhotelan pada tahun 1957 dengan dibukanya Twin Bridges Motor Hotel di Arlington, Virginia.</p>

<p>Kini, Marriott International telah bertransformasi menjadi salah satu perusahaan hospitality terbesar di dunia dengan puluhan brand mewah yang tersebar secara global.</p>

<hr>

<h2>5 Core Values Marriott International</h2>
<p>Keberhasilan Marriott berlandaskan pada lima nilai inti yang memandu seluruh operasional dan budaya kerja Ladies & Gentlemen:</p>
<ul>
    <li><strong>1. Put People First:</strong> "Take care of associates and they will take care of the customers." Karyawan adalah aset utama perusahaan.</li>
    <li><strong>2. Pursue Excellence:</strong> Bertekad untuk selalu memberikan layanan terbaik, memperhatikan setiap detail kecil, dan tidak pernah puas dengan standar rata-rata.</li>
    <li><strong>3. Embrace Change:</strong> Selalu berinovasi dan beradaptasi dengan perkembangan teknologi serta kebutuhan tamu modern.</li>
    <li><strong>4. Act with Integrity:</strong> Menjunjung tinggi kejujuran, etika, dan transparansi dalam setiap tindakan bisnis.</li>
    <li><strong>5. Serve Our World:</strong> Berkontribusi secara aktif bagi masyarakat lokal, kelestarian lingkungan, dan aksi sosial (Sustain & Serve).</li>
</ul>',
            'Thumbnail' => null,
            'order' => 1,
            'is_published' => true,
            'file_path' => null,
            'video_url' => null,
        ]);

        $q1 = Quiz::create([
            'module_id' => $mod1->id,
            'title' => 'Kuis Evaluasi Marriott Core Values',
            'description' => 'Evaluasi pemahaman sejarah dan nilai-nilai utama Marriott International.',
            'passing_score' => 80,
        ]);

        Question::create([
            'quiz_id' => $q1->id,
            'question' => 'Tahun berapa Marriott International berawal dari usaha A&W Root Beer di Washington, D.C. oleh J. Willard Marriott?',
            'option_a' => '1910',
            'option_b' => '1927',
            'option_c' => '1957',
            'option_d' => '1989',
            'correct_answer' => 'b',
        ]);

        Question::create([
            'quiz_id' => $q1->id,
            'question' => 'Manakah yang BUKAN merupakan bagian dari 5 Core Values Marriott International?',
            'option_a' => 'Put People First',
            'option_b' => 'Pursue Excellence',
            'option_c' => 'Profit First at All Cost',
            'option_d' => 'Act with Integrity',
            'correct_answer' => 'c',
        ]);

        // Modul 2: The Ritz-Carlton Gold Standards & Credo
        $mod2 = Module::create([
            'title' => 'The Ritz-Carlton Gold Standards & Credo',
            'slug' => Str::slug('The Ritz-Carlton Gold Standards & Credo'),
            'Description' => 'Mempelajari Motto, Credo, Brand Promise, serta Three Steps of Service khas The Ritz-Carlton.',
            'content' => '<h2>Gold Standards The Ritz-Carlton</h2>
<p>Gold Standards adalah fondasi budaya The Ritz-Carlton yang menjadi pedoman perilaku setiap staf dalam memberikan pengalaman layanan terbaik bagi tamu.</p>

<h3>1. The Credo</h3>
<p>"The Ritz-Carlton Hotel is a place where the genuine care and comfort of our guests is our highest mission. We pledge to provide the finest personal service and facilities for our guests who will always enjoy a warm, relaxed, yet refined ambience."</p>

<h3>2. The Motto</h3>
<blockquote><p><strong>"We are Ladies and Gentlemen serving Ladies and Gentlemen."</strong></p></blockquote>
<p>Pernyataan ini menegaskan integritas, profesionalisme, dan kesetaraan martabat seluruh staf di dalam melayani para tamu resort.</p>

<h3>3. Three Steps of Service</h3>
<ol>
    <li><strong>A warm and sincere greeting:</strong> Gunakan nama tamu jika memungkinkan.</li>
    <li><strong>Anticipation and fulfillment of each guest\'s needs:</strong> Peka terhadap kebutuhan mendesak maupun yang tidak terucap dari tamu.</li>
    <li><strong>A warm farewell:</strong> Berikan ucapan selamat jalan yang tulus dan sebut nama tamu.</li>
</ol>

<h3>4. The Brand Promise</h3>
<p><strong>"To create indelible marks"</strong> — Menciptakan kenangan indah yang tidak terlupakan dan membekas di hati setiap tamu selama mereka menginap.</p>',
            'Thumbnail' => null,
            'order' => 2,
            'is_published' => true,
            'file_path' => null,
            'video_url' => null,
        ]);

        $q2 = Quiz::create([
            'module_id' => $mod2->id,
            'title' => 'Kuis Gold Standards & Service Excellence',
            'description' => 'Uji pemahaman etika layanan dan filosofi The Ritz-Carlton.',
            'passing_score' => 80,
        ]);

        Question::create([
            'quiz_id' => $q2->id,
            'question' => 'Apa Motto resmi dari para staf di The Ritz-Carlton?',
            'option_a' => 'We Serve Contented Customers',
            'option_b' => 'We are Ladies & Gentlemen Serving Ladies & Gentlemen',
            'option_c' => 'Customer is Always Right',
            'option_d' => 'Excellence in Everything We Do',
            'correct_answer' => 'b',
        ]);

        Question::create([
            'quiz_id' => $q2->id,
            'question' => 'Apa Brand Promise dari The Ritz-Carlton kepada para tamu?',
            'option_a' => 'To create indelible marks',
            'option_b' => 'To offer the lowest prices',
            'option_c' => 'To build modern digital hotels',
            'option_d' => 'To provide fast self-service',
            'correct_answer' => 'a',
        ]);

        // Modul 3: Hotel Factsheet: The Ritz-Carlton, Bali
        $mod3 = Module::create([
            'title' => 'Hotel Factsheet: The Ritz-Carlton, Bali',
            'slug' => Str::slug('Hotel Factsheet The Ritz Carlton Bali'),
            'Description' => 'Profil properti seluas 12.7 hektar di Sawangan Nusa Dua, 313 Ocean Suites & Villas, dan fasilitas resort.',
            'content' => '<h2>Profil Properti</h2>
<p>Terletak di atas tebing batu kapur pesisir Sawangan, Nusa Dua, <strong>The Ritz-Carlton, Bali</strong> membentang di atas lahan seluas 12.7 hektar yang memadukan keindahan tebing (Cliff Side) dan pemandangan samudera (Beachfront).</p>

<hr>

<h2>Akomodasi & Kamar</h2>
<p>Property ini memiliki total <strong>313 Ocean Suites & Villas</strong>, yang terdiri dari:</p>
<ul>
    <li>The Ritz-Carlton Suite & Junior Suites</li>
    <li>Pool Pavilion Suites</li>
    <li>Cliff Villa & Sky Villas dengan kolam renang pribadi</li>
    <li>The Ritz-Carlton Cliff Top Oceanfront Villa</li>
</ul>

<hr>

<h2>Dining Outlets (Restoran & Bar)</h2>
<ul>
    <li><strong>Bejana:</strong> Restoran tebing ikonik yang menyajikan masakan autentik Indonesia khas Nusantara lengkap dengan <em>Culinary Cave</em>.</li>
    <li><strong>The Beach Grill:</strong> Mengusung tema open-air beachfront dengan sajian seafood segar dan panggangan daging olahan premium.</li>
    <li><strong>Senses:</strong> Restoran sarapan buffet internasional dengan beragam live cooking stations.</li>
    <li><strong>Raku:</strong> Restoran dan lounge Jepang yang menyajikan Sushi & Sashimi berkualitas tinggi.</li>
</ul>',
            'Thumbnail' => null,
            'order' => 3,
            'is_published' => true,
            'file_path' => null,
            'video_url' => null,
        ]);

        $q3 = Quiz::create([
            'module_id' => $mod3->id,
            'title' => 'Kuis Pengetahuan Properti Hotel',
            'description' => 'Uji wawasan mengenai fasilitas dan outlet The Ritz-Carlton, Bali.',
            'passing_score' => 80,
        ]);

        Question::create([
            'quiz_id' => $q3->id,
            'question' => 'Berapa jumlah total Suites & Villas yang dimiliki oleh The Ritz-Carlton, Bali?',
            'option_a' => '150 Suites',
            'option_b' => '200 Rooms',
            'option_c' => '313 Suites & Villas',
            'option_d' => '500 Rooms',
            'correct_answer' => 'c',
        ]);

        Question::create([
            'quiz_id' => $q3->id,
            'question' => 'Restoran manakah di The Ritz-Carlton, Bali yang menyajikan hidangan autentik Indonesia dan memiliki fasilitas Culinary Cave?',
            'option_a' => 'The Beach Grill',
            'option_b' => 'Bejana',
            'option_c' => 'Senses',
            'option_d' => 'The Raku',
            'correct_answer' => 'b',
        ]);

        // Modul 4: Etiket Kerja & Balance Scorecard Intern
        $mod4 = Module::create([
            'title' => 'Etiket Kerja & Balance Scorecard Intern',
            'slug' => Str::slug('Etiket Kerja & Balance Scorecard Intern'),
            'Description' => 'Panduan Telephone Etiquette, Office Etiquette, dan indikator penilaian evaluasi kinerja magang.',
            'content' => '<h2>Standar Etiket Komunikasi Telepon</h2>
<p>Sebagai staf maupun intern, telepon adalah sarana komunikasi penting dalam lingkungan profesional perhotelan:</p>
<ul>
    <li><strong>Maksimal 3 Dering:</strong> Telepon wajib diangkat sebelum atau pada dering ke-3.</li>
    <li><strong>Standar Greeting:</strong> Sebutkan salam, nama departemen, nama Anda, lalu tawarkan bantuan. Contoh: <em>"Good Morning, IT Department, Daniel speaking. How may I assist you?"</em></li>
    <li><strong>Hold Courtesy:</strong> Minta izin terlebih dahulu sebelum melakukan <em>hold</em> dan pastikan tidak menahan panggilan lebih dari 30 detik tanpa konfirmasi ulang.</li>
</ul>

<hr>

<h2>Intern Balance Scorecard & Penilaian</h2>
<p>Evaluasi kinerja peserta internship dilakukan secara berkala berbasis indikator berikut:</p>
<ul>
    <li><strong>Kehadiran (Attendance):</strong> Tingkat kehadiran minimal 90% selama periode magang.</li>
    <li><strong>Punctuality:</strong> Kedisiplinan waktu jam masuk dan pemenuhan tugas tepat waktu.</li>
    <li><strong>Core Values & Grooming:</strong> Kepatuhan terhadap standar pakaian/seragam kerja serta perilaku hospitality.</li>
    <li><strong>Technical Competency:</strong> Penilaian pemahaman materi modul dan hasil proyek tugas harian.</li>
</ul>',
            'Thumbnail' => null,
            'order' => 4,
            'is_published' => true,
            'file_path' => null,
            'video_url' => null,
        ]);

        $q4 = Quiz::create([
            'module_id' => $mod4->id,
            'title' => 'Kuis Standar Etiket & Kinerja Intern',
            'description' => 'Evaluasi pemahaman aturan kerja dan indikator kelulusan program intern.',
            'passing_score' => 80,
        ]);

        Question::create([
            'quiz_id' => $q4->id,
            'question' => 'Berapa jumlah dering maksimal untuk menjawab telepon masuk sesuai dengan standar Telephone Etiquette?',
            'option_a' => '1 dering',
            'option_b' => '3 dering',
            'option_c' => '5 dering',
            'option_d' => 'Bebas kapan saja',
            'correct_answer' => 'b',
        ]);

        // ==========================================
        // KATEGORI B: IT & NETWORK ENGINEERING
        // ==========================================

        // Modul 5: Dasar Jaringan Komputer & Pengalamatan IP
        $mod5 = Module::create([
            'title' => 'Dasar Jaringan Komputer & Pengalamatan IP',
            'slug' => Str::slug('Dasar Jaringan Komputer & Pengalamatan IP'),
            'Description' => 'Pemahaman arsitektur jaringan LAN/WLAN, IPv4, Subnetting, DHCP, Gateway, serta perangkat jaringan.',
            'content' => '<h2>Konsep Dasar Jaringan Komputer</h2>
<p>Jaringan komputer di lingkungan resort mengintegrasikan ribuan perangkat (kamar tamu, point-of-sale, server office, dan Access Point) agar saling terhubung secara aman.</p>

<h3>1. Pengalamatan IPv4 & Subnetting</h3>
<p>IP Address adalah alamat unik 32-bit yang mengidentifikasi setiap perangkat di dalam jaringan TCP/IP. Terbagi atas Network ID dan Host ID.</p>

<h3>2. Layanan Penting Jaringan</h3>
<ul>
    <li><strong>DHCP (Dynamic Host Configuration Protocol):</strong> Layanan otomatis yang mendistribusikan IP Address, Subnet Mask, dan Default Gateway kepada perangkat client.</li>
    <li><strong>DNS (Domain Name System):</strong> Penerjemah nama domain (misal: hotel.internal) menjadi IP Address.</li>
    <li><strong>Gateway:</strong> Gerbang pintu keluar jaringan lokal (LAN) menuju jaringan publik/Internet.</li>
</ul>',
            'Thumbnail' => null,
            'order' => 5,
            'is_published' => true,
            'file_path' => null,
            'video_url' => null,
        ]);

        $q5 = Quiz::create([
            'module_id' => $mod5->id,
            'title' => 'Kuis Dasar Jaringan Komputer',
            'description' => 'Uji pemahaman tentang pengalamatan IP dan fungsi perangkat jaringan.',
            'passing_score' => 80,
        ]);

        Question::create([
            'quiz_id' => $q5->id,
            'question' => 'Layanan jaringan yang berfungsi untuk memberikan IP Address secara otomatis kepada perangkat client adalah...',
            'option_a' => 'DNS Server',
            'option_b' => 'DHCP Server',
            'option_c' => 'FTP Server',
            'option_d' => 'Proxy Server',
            'correct_answer' => 'b',
        ]);

        // Modul 6: Pengujian & Pembuatan Kabel UTP dengan LAN Tester
        $mod6 = Module::create([
            'title' => 'Pengujian & Pembuatan Kabel UTP dengan LAN Tester',
            'slug' => Str::slug('Pengujian & Pembuatan Kabel UTP dengan LAN Tester'),
            'Description' => 'Standar T568B, pembuatan kabel Straight vs Crossover, crimping RJ-45, dan pengujian Wiremap Tester.',
            'content' => '<h2>Standar Urutan Warna T568B</h2>
<p>Standar yang paling umum digunakan dalam instalasi jaringan LAN perhotelan adalah standar T568B dengan urutan 8 pin sebagai berikut:</p>
<ol>
    <li>Putih - Orange</li>
    <li>Orange</li>
    <li>Putih - Hijau</li>
    <li>Biru</li>
    <li>Putih - Biru</li>
    <li>Hijau</li>
    <li>Putih - Cokelat</li>
    <li>Cokelat</li>
</ol>

<hr>

<h2>Pengujian dengan LAN Wiremap Tester</h2>
<p>Setelah melakukan <em>crimping</em> konektor RJ-45, fisik kabel wajib diuji menggunakan LAN Tester:</p>
<ul>
    <li><strong>Straight-Through:</strong> Lampu indikator nomor 1 hingga 8 pada Main Unit dan Remote Unit harus menyala berurutan secara sejajar (1-1, 2-2, 3-3, dst.).</li>
    <li><strong>Open/Short Failure:</strong> Jika terdapat angka yang mati atau menyala secara acak, menandakan adanya pin terputus (open) atau kabel saling menempel (short).</li>
</ul>',
            'Thumbnail' => null,
            'order' => 6,
            'is_published' => true,
            'file_path' => null,
            'video_url' => null,
        ]);

        $q6 = Quiz::create([
            'module_id' => $mod6->id,
            'title' => 'Kuis Pengabelan & Wiremap Test',
            'description' => 'Uji kemampuan analisa pembuatan dan pengujian kabel UTP.',
            'passing_score' => 80,
        ]);

        Question::create([
            'quiz_id' => $q6->id,
            'question' => 'Pada standar urutan warna T568B, warna kabel untuk Pin 1 dan Pin 2 secara berurutan adalah...',
            'option_a' => 'Putih-Hijau, Hijau',
            'option_b' => 'Putih-Orange, Orange',
            'option_c' => 'Putih-Biru, Biru',
            'option_d' => 'Putih-Cokelat, Cokelat',
            'correct_answer' => 'b',
        ]);

        Question::create([
            'quiz_id' => $q6->id,
            'question' => 'Alat utama yang digunakan untuk menguji kontinuitas fisik dan urutan pin pada kabel RJ-45 adalah...',
            'option_a' => 'Crimping Tool',
            'option_b' => 'LAN Wiremap Tester',
            'option_c' => 'Multimeter Digital',
            'option_d' => 'Spectrum Analyzer',
            'correct_answer' => 'b',
        ]);

        // Modul 7: Network Troubleshooting & Diagnosa Access Point
        $mod7 = Module::create([
            'title' => 'Network Troubleshooting & Diagnosa Access Point',
            'slug' => Str::slug('Network Troubleshooting & Diagnosa Access Point'),
            'Description' => 'Teknik mendiagnosa masalah jaringan, isolasi masalah fisik kabel vs System Error pada Access Point.',
            'content' => '<h2>Isolasi Masalah Hardware vs System Error</h2>
<p>Ketika terjadi laporan bahwa Wi-Fi di area villa/restoran terputus, langkah isolasi insiden dilakukan sebagai berikut:</p>

<h3>1. Uji Kontinuitas Fisik (Wiremap Test)</h3>
<p>Lakukan testing pada jalur kabel LAN dari Switch PoE ke lokasi Access Point (misal: Aruba AP). Jika hasil pengujian LAN Tester menunjukkan angka 1 sampai 8 menyala sempurna, maka **fisik kabel terbebas dari kesalahan**.</p>

<h3>2. Identifikasi System / Configuration Error</h3>
<p>Jika fisik kabel 100% normal namun AP tidak menyala / tidak mendapatkan IP, maka kendala dialihkan ke pengujian sistem:</p>
<ul>
    <li>Periksa ketersediaan daya PoE pada port Switch.</li>
    <li>Cek alokasi VLAN pada port Switch target.</li>
    <li>Periksa error status/log pada Aruba Mobility Controller (System Error / Provisioning Mismatch).</li>
</ul>',
            'Thumbnail' => null,
            'order' => 7,
            'is_published' => true,
            'file_path' => null,
            'video_url' => null,
        ]);

        $q7 = Quiz::create([
            'module_id' => $mod7->id,
            'title' => 'Kuis Troubleshooting Jaringan & Hardware',
            'description' => 'Evaluasi kemampuan analisa insiden jaringan di lingkungan perhotelan.',
            'passing_score' => 80,
        ]);

        Question::create([
            'quiz_id' => $q7->id,
            'question' => 'Jika hasil pengujian wiremap tester menunjukkan kabel LAN 100% baik, namun Access Point tetap tidak terhubung ke controller, indikasi masalah berikutnya adalah...',
            'option_a' => 'Kerusakan fisik pada seluruh kabel UTP',
            'option_b' => 'System Error / konfigurasi port PoE Switch / Controller AP',
            'option_c' => 'Konektor RJ45 harus diganti lagi',
            'option_d' => 'Kabel Power listrik terputus',
            'correct_answer' => 'b',
        ]);

        // Modul 8: Administrasi Sistem Operasi Windows untuk IT Support
        $mod8 = Module::create([
            'title' => 'Administrasi Sistem Operasi Windows untuk IT Support',
            'slug' => Str::slug('Administrasi Sistem Operasi Windows untuk IT Support'),
            'Description' => 'Penggunaan perintah CLI Windows (ipconfig, ping, tracert), pengelolaan Services, dan Event Viewer.',
            'content' => '<h2>Command Line Tools Wajib IT Support</h2>
<p>Berikut beberapa perintah CLI Windows yang umum digunakan untuk melakukan diagnosa cepat masalah konektivitas pada PC kerja staff:</p>

<ul>
    <li><code>ipconfig /all</code>: Menampilkan informasi lengkap adapter jaringan, MAC address, IP, Subnet, dan DHCP Server.</li>
    <li><code>ipconfig /release</code> & <code>ipconfig /renew</code>: Melepas dan meminta ulang IP Address baru dari DHCP Server.</li>
    <li><code>ipconfig /flushdns</code>: Membersihkan cache DNS pada sistem Windows.</li>
    <li><code>ping [IP_Target] -t</code>: Melakukan pengujian kontinuitas paket data ke perangkat target secara terus-menerus.</li>
    <li><code>tracert [IP_Target]</code>: Menelusuri rute lompatan (hop) router yang dilalui paket data hingga ke tujuan.</li>
</ul>',
            'Thumbnail' => null,
            'order' => 8,
            'is_published' => true,
            'file_path' => null,
            'video_url' => null,
        ]);

        $q8 = Quiz::create([
            'module_id' => $mod8->id,
            'title' => 'Kuis Administrasi Windows OS',
            'description' => 'Uji keterampilan penanganan masalah sistem operasi Windows.',
            'passing_score' => 80,
        ]);

        Question::create([
            'quiz_id' => $q8->id,
            'question' => 'Perintah CLI Windows yang digunakan untuk memperbarui atau meminta kembali IP Address dari server DHCP adalah...',
            'option_a' => 'ipconfig /flushdns',
            'option_b' => 'ipconfig /renew',
            'option_c' => 'ping 127.0.0.1',
            'option_d' => 'netstat -an',
            'correct_answer' => 'b',
        ]);
    }
}