package models

// Admin model
type Admin struct {
	ID       int    `json:"id"`
	Email    string `json:"email"`
	Username string `json:"username"`
	Password string `json:"password"`
}

type AdminResponse struct {
	Username string `json:"username"`
}

// Siswa model
type Siswa struct {
	NIS      string `json:"nis"`
	Kelas    string `json:"kelas"`
	Username string `json:"username"`
	Email    string `json:"email"`
	Password string `json:"password"`
}

// Kategori model
type Kategori struct {
	ID          int    `json:"id_kategori"`
	KetKategori string `json:"ket_kategori"`
}

// Aspirasi model
type Aspirasi struct {
	IDAspirasi  int    `json:"id_aspirasi"`
	Status      string `json:"status"`
	IDKategori  int    `json:"id_kategori"`
	Feedback    string `json:"feedback"`
	IDPelaporan int    `json:"id_pelaporan"`
}

// InputAspirasi model
type InputAspirasi struct {
	IDPelaporan int    `json:"id_pelaporan"`
	NIS         string `json:"nis"`
	IDKategori  int    `json:"id_kategori"`
	Lokasi      string `json:"lokasi"`
	Ket         string `json:"ket"`
}

// Response wrapper
type Response struct {
	Success bool        `json:"success"`
	Message string      `json:"message"`
	Data    interface{} `json:"data"`
}
