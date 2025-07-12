# **Migrasi File SQL**
- Masuk ke phpMyAdmin
- Tekan **New** untuk membuat database baru
- Pilih menu **Import**
- Di dalam **File to import**, pilih **Choose File** dan ambil **rest_api.sql** di dalam folder File Database
- Setelah file dipilih, tekan import yang berada paling bawah
- Database telah masuk di phpMyAdmin dan Anda telah melakukan migrasi file SQL.
# **Menjalankan REST API di Postman**
#### Sebelum menjalankan REST API ikuti langkat-langkah berikut ini:
- Masuk ke aplikasi Postman
- Tekan menu **Collections**
- **Create new collection** untuk membuat koleksi baru
- Setelah membuat new collection, pilih **View more actions** dan tekan **Add request**
- Pilih metode HTTP dan masukkan URL yang akan digunakan untuk menjalankan REST API

## 1. URL Untuk Melakukan Login
### <span style = "color: #FFEE8C;">**POST**</span> http://localhost/back_end_projek_uas/rest_api/Public/api/auth/login
#### 1. Masukkan di **Headers** Key dan Value

| Key      		 	| Value   			 |
| ----------------- | ------------------ |
| Content-Type   	| application/json	 |

#### 2. Masukkan program di bagian **Body** raw setting **JSON**

```JSON
{
   "username": "Johndoe",
   "password": "admin123"
}
```
Tekan **Send**.

Maka dengan demikian, akan terlihat hasil setelah melakukan login:
```JSON
{
    "pesan": "Login berhasil!",
    "token": "929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb",
    "expires_at": "25-07-11 14:49:52",
    "user": {
        "id": 1,
        "username": "Johndoe",
        "role": "superadmin"
    }
}
```
#### 3. Lalu ambil atau salin token unik yang nanti digunakan untuk beberapa proses CRUD, select dan logout
| Key      		 	| Value   			  |
| ----------------- | ------------------  |
| Authorization   	| Bearer `token unik` |

Contoh:

`Bearer 929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb`

**Note**: token setelah melakukan login hanya berlaku selama beberapa jam.
#### ***Langkah yang ketiga tidak dilakukan setting Authorization maupun token di Headers, hanya mengambil token saja.**

## 2. URL Untuk Logout
### <span style = "color: #FFEE8C;">**POST**</span> http://localhost/back_end_projek_uas/rest_api/Public/api/auth/logout
**Persyaratan: role user atau superadmin yg telah melakukan login**

#### 1. Isi di bagian **Headers** Key dan Value
| Key      		 	| Value   			  														|
| ----------------- | ------------------------------------------------------------------------  |
| Authorization   	| `Bearer 929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb` |

Tanpa menggunakan **Body** raw dan mengisi program **JSON**.

Jika sudah mengisi token unik di bearer, maka logout berhasil dilakukan dengan menekan **Send**. Dikeluarkan pemberitahuan sebagai berikut:

```JSON
{
    "pesan": "Logout berhasil!"
}
```

## 3. URL Untuk Menampilkan Semua Mahasiswa
### <span style="color: #98FF98;">**GET**</span> http://localhost/back_end_projek_uas/rest_api/Public/api/student
**Persyaratan: superadmin**

#### 1. Masukkan token yang didapat dari sesi login

| Key      		 	| Value   			  													   |
| ----------------- | ------------------------------------------------------------------------ |
| Authorization   	| `Bearer 929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb`|

Lalu tekan **Send** untuk menampilkan hasil.

## 4. URL Untuk Menampilkan Data Mahasiswa Berdasarkan id-nya
### <span style="color: #98FF98;">**GET**</span> http://localhost/back_end_projek_uas/rest_api/Public/api/student/1 (1 itu adalah id-nya)
**Persyaratan: superadmin**

#### 1. Masukkan token di **Headers** setelah melakukan proses login
| Key      		 	| Value   			  													   |
| ----------------- | ------------------------------------------------------------------------ |
| Authorization   	| `Bearer 929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb`|

Tanpa ada pengisian data di **Params** maupun **Body** raw.
Tekan **Send** untuk melihat data berdasarkan id.

```JSON
{
    "id": 1,
    "nama": "Jane Smith",
    "prodi": "Sistem Informasi"
}
```
## 5. URL Untuk Menambahkan Data Mahasiswa ke Dalam Tabel
### <span style = "color: #FFEE8C;">**POST**</span> http://localhost/back_end_projek_uas/rest_api/Public/api/student
**Persyaratan: superadmin**

#### 1.Masukkan terlebih dahulu di **Headers** Content-Type
| Key      		 	| Value   			 |
| ----------------- | ------------------ |
| Content-Type   	| application/json	 |

Setelah itu token diisi di field Value.
| Key      		 	| Value   			 													   |
| ----------------- | ------------------------------------------------------------------------ |
| Content-Type   	| application/json	 													   |
| Authorization   	| `Bearer 929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb`|

#### 2. Masukkan kode di **Body** raw setting **JSON**:
```JSON
{
    "name": "Donny",
    "prodi": "Teknologi Informasi"
}
```

Lalu tekan **Send** untuk menambahkan data mahasiswa baru.
Maka terlihat pemberitahuan bahwa data telah diisi.
```JSON
{
    "pesan": "Data Mahasiswa telah berhasil dibuat",
    "id": "6"
}
```
## 6.  URL Untuk Mengubah Data Berdasarkan id mahasiswa
### <span style="color: #6495ED">**PUT**</span> http://localhost/back_end_projek_uas/rest_api/Public/api/student/6 (6 adalah id-nya)
**Persyaratan: superadmin**

#### 1. Di bagian **Headers**, masukkan:
| Key      		 	| Value   			 													   |
| ----------------- | ------------------------------------------------------------------------ |
| Content-Type   	| application/json	 													   |
| Authorization   	| `Bearer 929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb`|

#### 2. Untuk di bagian **Body**, pilih raw lalu setting ke **JSON**
Isi program sebagai berikut:
```JSON
{
    "name": "Doni",
    "prodi": "Sistem Informasi"
}
```
Setelah itu, tekan **Send** untuk mengubah data mahasiswa dan pesan akan muncul setelah data diubah.
```JSON
{
    "pesan": "Data mahasiswa berhasil diperbarui!"
}
```
## 7. URL Untuk Menghapus Data Berdasarkan id mahasiswa:
### <span style="color: #FA8072">**DELETE**</span> http://localhost/back_end_projek_uas/rest_api/Public/api/student/6 (6 adalah contoh id-nya)
**Persyaratan: superadmin**

#### 1. Isi di bagian **Headers** token yang didapat dari sesi login
| Key      		 	| Value   			  													   |
| ----------------- | ------------------------------------------------------------------------ |
| Authorization   	| `Bearer 929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb`|

Lalu tekan **Send** untuk menghapus data mahasiswa yang berada pada id tersebut.
Setelah data dihapus, ditampilkan pemberitahuan sebagai berikut:
```JSON
{
    "message": "Data mahasiswa telah dihapus"
}
```
## 8. URL Untuk Mengecek Data Pengguna Saat Ini
### <span style="color: #98FF98;">**GET**</span> http://localhost/back_end_projek_uas/rest_api/Public/api/auth/me
**Persyaratan: user atau superadmin yang sudah login**

#### 1. Di bagian **Headers**, lakukan setting token
| Key      		 	| Value   			  													   |
| ----------------- | ------------------------------------------------------------------------ |
| Authorization   	| `Bearer 929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb`|

Selanjutnya, tekan **Send** untuk menampilkan data pengguna saat ini.
```JSON
{
	"id": 1,
    "username": "Johndoe",
    "role": "superadmin"
}
```
## 9. URL Untuk Menampilkan Semua Data User
### <span style="color: #98FF98;">**GET**</span> http://localhost/back_end_projek_uas/rest_api/Public/api/users
**Persyaratan: superadmin**

#### 1. Masukkan Key Authorization di **Headers** dengan token unik untuk Value-nya

Contoh Value Bearer:
| Key      		 	| Value   			  													   |
| ----------------- | ------------------------------------------------------------------------ |
| Authorization   	| `Bearer 929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb`|

Lalu tekan **Send** untuk melihat semua data user.

## 10. URL Untuk Menampilkan Data Berdasarkan id User
### <span style="color: #98FF98;">**GET**</span> http://localhost/back_end_projek_uas/rest_api/Public/api/users/1 (1 adalah contohnya id-nya)
**Persyaratan: superadmin**

#### 1.Masukkan Key: Authorization dan Value: Bearer "token unik" seperti cara yang sebelumnya
| Key      		 	| Value   			  													   |
| ----------------- | ------------------------------------------------------------------------ |
| Authorization   	| `Bearer 929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb`|

Dengan menekan tombol **Send**, pengguna telah ditampilkan berdasarkan nomor id-nya.
```JSON
	"id": 1,
    "username": "Johndoe",
    "role": "superadmin"
```

## 11. URL Untuk Membuat Data User yang Baru
### <span style = "color: #FFEE8C;">**POST**</span> http://localhost/back_end_projek_uas/rest_api/Public/api/users
**Persyaratan: superadmin**

#### 1. Di bagian **Headers**, masukkan Content-Type di Key dan Valuenya adalah application/json
| Key      		 	| Value   			 |
| ----------------- | ------------------ |
| Content-Type   	| application/json	 |

#### 2. Setelah itu, masukkan Authorization dan Bearer "token unik" ketika sudah login menjadi superuser
| Key      		 	| Value   			  													   |
| ----------------- | ------------------------------------------------------------------------ |
| Authorization   	| `Bearer 929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb`|

#### 3. Masuk ke bagian **Body** pilih raw lalu tekan setting ke **JSON**
Isi program sebagai berikut:
```JSON
{
	"username": "Donnysandika",
	"password": "Doni17411",
	"role": "user"
}
```
Lalu tekan **Send** untuk menambahkan data user.
```JSON
{
    "pesan": "Pengguna berhasil ditambahkan"
}
```

## 12. URL Untuk Mengubah atau Update Data Berdasarkan id User
### <span style="color: #6495ED">**PUT**</span> http://localhost/back_end_projek_uas/rest_api/Public/api/users/7 (7 adalah contoh id-nya)
**Persyaratan: superadmin**

#### 1. Masukkan untuk Key Content-Type, Value application/json di **Headers**
| Key      		 	| Value   			 |
| ----------------- | ------------------ |
| Content-Type   	| application/json	 |

#### 2. Isi juga Authorization untuk Key dan Bearer "token unik" untuk Value-nya
| Key      		 	| Value   			  													   |
| ----------------- | ------------------------------------------------------------------------ |
| Authorization   	| `Bearer 929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb`|
#### 3. Di bagian **Body** pilih raw dan untuk setting kedua pilih **JSON**
Dengan mengisi program berikut:
```JSON
{
	"username": "DoniSandika",
	"password": "ionD5692",
	"role": "superadmin"
}
```

Setelah itu, tekan **Send** untuk mengubah data.
```JSON
{
    "pesan": "Pengguna berhasil diperbarui"
}
```
## 13. URL Untuk Menghapus Data Berdasarkan id User
### <span style="color: #FA8072">**DELETE**</span> http://localhost/back_end_projek_uas/rest_api/Public/api/users/7 (7 adalah contoh id-nya)
**Persyaratan: superadmin**

#### 1. Isi Key Authorization dan Value Bearer "token unik" di **Headers**
| Key      		 	| Value   			  													   |
| ----------------- | ------------------------------------------------------------------------ |
| Authorization   	| `Bearer 929669d97c319a1945d238416cb351e8208a2b30c353271a1ad3c87c198e2bdb`|

Lalu tekan **Send**.
```JSON
{
    "pesan": "Pengguna berhasil dihapus"
}
```
