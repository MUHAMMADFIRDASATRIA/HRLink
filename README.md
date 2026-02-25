<div align="center">

<img src="https://img.shields.io/badge/version-1.0.0-4db89e?style=for-the-badge" />
<img src="https://img.shields.io/badge/license-MIT-blue?style=for-the-badge" />
<img src="https://img.shields.io/badge/status-active-success?style=for-the-badge" />

<br /><br />

```
                                ██╗  ██╗██████╗ ██╗     ██╗███╗   ██╗██╗  ██╗
                                ██║  ██║██╔══██╗██║     ██║████╗  ██║██║ ██╔╝
                                ███████║██████╔╝██║     ██║██╔██╗ ██║█████╔╝
                                ██╔══██║██╔══██╗██║     ██║██║╚██╗██║██╔═██╗
                                ██║  ██║██║  ██║███████╗██║██║ ╚████║██║  ██╗
                                ╚═╝  ╚═╝╚═╝  ╚═╝╚══════╝╚═╝╚═╝  ╚═══╝╚═╝  ╚═╝
```

# 🔗 HRLink — Sistem Monitoring PKWT

**Aplikasi manajemen dan monitoring kontrak kerja (PKWT) berbasis web yang modern, cepat, dan mudah digunakan.**

<br />

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=flat-square&logo=vue.js&logoColor=white)](https://vuejs.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![Vite](https://img.shields.io/badge/Vite-5.x-646CFF?style=flat-square&logo=vite&logoColor=white)](https://vitejs.dev)

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Prasyarat](#-prasyarat)

---

## 📌 Tentang Proyek

**HRLink** adalah sistem informasi berbasis web yang dirancang untuk membantu tim Human Resources dalam memantau dan mengelola kontrak kerja waktu tertentu **(PKWT)**. Sistem ini memberikan visibilitas penuh terhadap status kontrak karyawan — dari yang masih aktif, akan segera berakhir, hingga yang sudah kedaluwarsa — secara real-time dalam satu dashboard terpusat.

> 💡 Dibangun dengan semangat **"HRD lebih fokus ke orang, bukan ke spreadsheet."**

---

## ✨ Fitur Utama

| Fitur                    | Deskripsi                                 | Status  |
| ------------------------ | ----------------------------------------- | ------- |
| 🔐 **Autentikasi**       | Login aman dengan JWT / Sanctum           | ✅ Done |
| 📊 **Dashboard**         | Rekap statistik PKWT secara real-time     | ✅ Done |
| 👥 **Data Karyawan**     | Manajemen lengkap data karyawan           | ✅ Done |
| 📄 **Data PKWT**         | CRUD kontrak beserta histori perubahan    | ✅ Done |
| 🔔 **Reminder**          | Notifikasi otomatis kontrak akan berakhir | ✅ Done |
| 🏢 **Kelola Departemen** | Master data departemen perusahaan         | ✅ Done |
| 🪪 **Kelola Jabatan**    | Master data jabatan / posisi              | ✅ Done |
| 📈 **Grafik & Chart**    | Visualisasi data PKWT per periode         | ✅ Done |
| 📱 **Responsive UI**     | Tampilan optimal di semua ukuran layar    | ✅ Done |

---

## 🛠️ Tech Stack

<div align="center">

<table>
  <tr>
    <th>Backend</th>
    <th>Frontend</th>
  </tr>
  <tr>
    <td align="left">
      <ul>
        <li>🚀 <b><a href="https://laravel.com">Laravel 11</a></b></li>
        <li>🔒 <b><a href="https://laravel.com/docs/sanctum">Sanctum</a></b></li>
        <li>🗄️ <b><a href="https://mysql.com">MySQL 8</a></b></li>
        <li>🛡️ <b><a href="https://spatie.be/docs/laravel-permission">Spatie Permission</a></b></li>
      </ul>
    </td>
    <td align="left">
      <ul>
        <li>🌱 <b><a href="https://vuejs.org">Vue.js 3</a></b></li>
        <li>🎨 <b><a href="https://tailwindcss.com">Tailwind CSS 3</a></b></li>
        <li>🧭 <b><a href="https://router.vuejs.org">Vue Router 4</a></b></li>
        <li>🔗 <b><a href="https://axios-http.com">Axios</a></b></li>
        <li>⚡ <b><a href="https://vitejs.dev">Vite</a></b></li>
      </ul>
    </td>
  </tr>
</table>

</div>

---

## ✅ Prasyarat

Pastikan environment kamu sudah memiliki tools berikut sebelum memulai instalasi:

```
PHP        >= 8.2
Composer   >= 2.x
Node.js    >= 18.x
NPM        >= 9.x  (atau Yarn / PNPM)
MySQL      >= 8.0
Git        >= 2.x
```
