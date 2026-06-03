**COMPUTING PROJECT**

**SOFTWARE DESIGN DOCUMENT**

**Rancang Bangun Website Company Profile dan Sistem Reservasi Studio Foto Berbasis Web dengan Fitur Chatbot menggunakan Algoritma Levenshtein pada Sejenak Studio Purwokerto**



![A logo with a red book and a black background&#x0A;&#x0A;AI-generated content may be incorrect.](Aspose.Words.65227898-10a3-46c9-a5a9-364969384e25.001.png)



**Project Manager**

Ibnu Rizal Mutaqim		2311102067

**Team Members**

Bintang Yudhistira			2311102052

Muhammad Nasrulloh			2311102044

Muhammad Agha Zulfadhli		2311102015

Anita Nurazizah Agussalim		2311102017

Hendwi Saputra			2311102218

**Supervisor**

Amalia Beladinna Arifa, S.Pd., M.Cs?



**PROGRAM STUDI S-1 TEKNIK INFORMATIKA**

**DIREKTORAT KAMPUS PURWOKERTO – UNIVERSITAS TELKOM**

**MARET 2026**



# **Document Version**

|Versi||
| - | - |
|Tanggal||
|Perubahan||
|Penulis||



# **Table of Content**




1. # **Introduction**
   1. ## **Purpose**
Menjelaskan tujuan dokumen SDD ini dibuat, serta bagaimana dokumen ini digunakan oleh developer dan tim teknis.
1. ## **Scope of the System**
Gambaran umum tentang sistem (dirangkum dalam paragraf):

- Fungsi utama sistem
- User utama
- Benefit dengan adanya sistem yang dikembangkan
- Platform (web/mobile/desktop) yang digunakan untuk menjalankan aplikasi ini
  1. ## **References**
Daftar referensi yang menjadi dasar desain:

- Dokumen SRS,
- API standards,
- UI/UX guidelines, etc.


1. # **System Architecture Design**
Menjelaskan arsitektur tingkat tinggi untuk seluruh sistem.
1. ## **Use Case Diagram**
Diagram ini menunjukkan cakupan fungsi yang akan diimplementasikan dan menjadi jembatan dari SRS ke desain teknis.
1. ## **High-Level Architecture Diagram**
Diagram blok arsitektur yang menunjukkan:

- Frontend
- Backend
- Database
- External API
- Authentication server
- AI/ML Engine (jika ada)
  1. ## **Deployment Architecture**
Menjelaskan bagaimana sistem dijalankan (bisa ditulis dalam paragraf):

- On-premise / cloud
- Docker / Kubernetes
- CI/CD pipeline
- Server vs client


1. # **Module Design**
Ini adalah bagian terpenting dalam SDD. SDD harus menjelaskan **setiap modul** dalam sistem/software yang dibangun.
1. ## **Module List**
Daftar modul, misalnya:

- Authentication Module
- User Management Module
- Dashboard Module
- ML Inference Module
- Notification Module
  1. ## **Module Description (per modul)**
Setiap modul memiliki sub-bagian, seperti:

- Purpose: fungsi modul
- Inputs & Outputs
- Component Responsibilities
- Internal Logic Description
- Class/Function Responsibilities
- Error Handling Strategy

Dapat menggunakan format tabel seperti berikut.

|Komponen|Deskripsi|
| :- | :- |
|Nama Modul|…|
|Tujuan|…|
|Input|…|
|Output|…|
|Dependency|…|
|Catatan|…|


1. # **Class Diagram and Object Design**
   1. ## **Class Diagram**
Diagram class UML untuk menunjukkan:

- Atribut
- Method
- Relasi (inheritance, association, aggregation, composition)

Buat sebagaimana Anda membuatnya pada mata kuliah yang sebelumnya sudah pernah Anda ambil dan pelajari. Sesuaikan dengan proyek yang dikerjakan di sini.
1. ## **Object Interaction**
Bagian ini dapat dibuat sebagai:

- Sequence diagrams, atau
- Collaboration diagrams.

Sequence diagram wajib ada untuk fitur penting, seperti:

- Login
- Upload data
- Proses inferensi AI
- Transaksi


1. # **Database Design**
   1. ## **Entity Relationship Diagram (ERD)**
Diagram relasi antar tabel. Buat sebagaimana Anda membuatnya pada mata kuliah yang sebelumnya sudah pernah Anda ambil dan pelajari. Sesuaikan dengan proyek yang dikerjakan di sini.
1. ## **Database Schema Definitions**
Menjelaskan tiap tabel data dan atributnya. Dapat disusun dalam bentuk tabel, sebagai contoh, seperti berikut.

|Field|Type|Description|
| :- | :- | :- |
||||


1. # **User Interface Design (UI/UX)**
   1. ## **Wireframes / Mockups**
Tampilkan gambar-gambar (sertai penjelasan singkat atau caption) untuk:

- Landing Page
- Login Page
- Dashboard
- Input Page
- Reports Page
  1. ## **Navigation Flow**
Diagram alur navigasi antar halaman.


1. # **Data Flow and Process Flow**
   1. ## **Data Flow Diagram (DFD)**
Gambarkan DFD untuk level 0, 1, 2, dst. sesuai kebutuhan. Buat sebagaimana Anda membuatnya pada mata kuliah yang sebelumnya sudah pernah Anda ambil dan pelajari. Sesuaikan dengan proyek yang dikerjakan di sini.
1. ## **Activity Diagram**
Menjelaskan alur proses, misalnya, yang ada pada:

- Login
- Transaksi
- Proses AI
- Validasi data
  1. ## **State Machine Diagram (jika ada)**
Jika ada objek yang berubah status (order, user role, task assignment).


1. # **System Constraints**
Pada bagian ini, jelaskan batasan-batasan yang diterapkan pada implementasi. Sebagai contoh, dapat meliputi:

- Hardware limitations
- Software version constraints
- Regulatory constraints (UU PDP)
- Budget/time constraints

System constraints ini dapat ditulis dalam paragraf.


1. # **Appendix**
Berisi lampiran-lampiran yang dibutuhkan




