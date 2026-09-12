# Project: Sistem Tiketing Digital Kebun Raya

## Skenario & Spesifikasi Proyek

Pengelola Kebun Raya membutuhkan sistem tiketing digital mandiri untuk mempermudah pengunjung membeli tiket secara online. Sebagai seorang pengembang perangkat lunak mandiri (solo developer), diminta membangun aplikasi web seperti pada link contoh flow taman safari/kebun raya, dengan alur utama sebagai berikut:

| Tahap | Aktor Utama | Deskripsi Aktivitas | Output Sistem |
|---|---|---|---|
| 1. Pemesanan | Pengunjung (User) | Pilih tanggal kunjungan, kategori tiket (Dewasa/Anak), dan jumlah tiket. | Kode Invoice & Tagihan Total |
| 2. Pembayaran | Pengunjung (User) | Melakukan pembayaran dan mengunggah (upload) bukti pembayaran. | Status: "Menunggu Konfirmasi" |
| 3. Konfirmasi | Pengelola (Admin) | Admin mengecek bukti bayar di dashboard lalu menekan tombol Approve. | Status: "LUNAS / TERVERIFIKASI" |
| 4. Unduh Tiket | Pengunjung (User) | Akses menu riwayat transaksi dan menekan tombol "Download E-Ticket". | Berkas E-Ticket (PDF/Gambar + QR Code) |

## Instruksi Penugasan Individu

### Spesifikasi Output E-Ticket Digital

Tiket digital yang dihasilkan oleh sistem setelah pembayaran lunas wajib mengikuti struktur tertentu (berisi PDF/Gambar dengan Kode QR yang aktif setelah status pembayaran menjadi Lunas).

> **Catatan:** Pada dokumen PDF asli, detail lengkap struktur E-Ticket (field apa saja yang wajib ada di dalam tiket) tampaknya terpotong/hilang saat konversi — teksnya langsung meloncat ke bagian checklist pengujian di bawah. Jika kamu punya detail struktur E-Ticket ini di sumber lain, tambahkan ke sini.

### Lembar Pengujian Fitur (Testing Checklist)

| No | Kriteria Pengujian | Ekspektasi Hasil | Status |
|---|---|---|---|
| 1 | User memilih tanggal & jumlah tiket | Total harga dihitung secara otomatis | [ ] Pass |
| 2 | User mengunggah bukti bayar | File tersimpan & status menjadi "Pending" | [ ] Pass |
| 3 | User mencoba unduh tiket sebelum konfirmasi | Tombol unduh terkunci / disabled | [ ] Pass |
| 4 | Admin menekan tombol "Konfirmasi" | Status berubah menjadi "Lunas" | [ ] Pass |
| 5 | User menekan tombol "Download Tiket" | File E-Ticket (PDF/Image) berhasil diunduh | [ ] Pass |
