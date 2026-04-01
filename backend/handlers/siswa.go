package handlers

import (
	"encoding/json"
	"log"
	"net/http"

	"pengaduan/database"
	"pengaduan/models"

	"github.com/gorilla/mux"
)

func GetSiswaByNIS(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)
	nis := vars["nis"]

	if nis == "" {
		http.Error(w, "Invalid NIS", http.StatusBadRequest)
		return
	}

	var siswa models.Siswa
	data, _, err := database.DB.From("siswa").
		Select("*", "exact", false).
		Eq("nis", nis).
		Single().
		Execute()
	if err != nil {
		http.Error(w, "Student not found", http.StatusNotFound)
		return
	}

	if err := json.Unmarshal(data, &siswa); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Student found",
		Data:    siswa,
	})
}

func GetAllSiswa(w http.ResponseWriter, r *http.Request) {
	var siswaList []models.Siswa
	data, _, err := database.DB.From("siswa").
		Select("nis, kelas", "exact", false).
		Execute()
	if err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	if err := json.Unmarshal(data, &siswaList); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Students retrieved",
		Data:    siswaList,
	})
}

func GetSiswaByNisAndEmailPassword(w http.ResponseWriter, r *http.Request) {
	log.Printf("Query: %v", r.URL.Query())


	nis := r.URL.Query().Get("nis")
	email := r.URL.Query().Get("email")
	password := r.URL.Query().Get("password")

	var siswa models.Siswa
	data, _, err := database.DB.From("siswa").
		Select("*", "exact", false).
		Eq("nis", nis).
		Eq("email", email).
		Eq("password", password).
		Single().
		Execute()
	if err != nil {
		http.Error(w, "Student not found", http.StatusNotFound)
		return
	}

	if err := json.Unmarshal(data, &siswa); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Student found",
		Data:    siswa,
	})
}

// CreateSiswa creates a new student
func CreateSiswa(w http.ResponseWriter, r *http.Request) {
	var siswa models.Siswa
	if err := json.NewDecoder(r.Body).Decode(&siswa); err != nil {
		log.Printf("Error Decode JSON: %v", err)
		http.Error(w, "Invalid request payload", http.StatusBadRequest)
		return
	}

	var result []models.Siswa
	data, _, err := database.DB.From("siswa").
		Insert(map[string]interface{}{
			"nis":      siswa.NIS,
			"kelas":    siswa.Kelas,
			"username": siswa.Username,
			"email":    siswa.Email,
			"password": siswa.Password,
		}, false, "", "", "").
		Execute()
	if err != nil {
		log.Printf("Error Insert Siswa: %v", err)                        // ✅ log error
		http.Error(w, "Gagal menyimpan data siswa", http.StatusConflict) // ✅ pesan berbeda
		return
	}

	if err := json.Unmarshal(data, &result); err != nil {
		log.Printf("Error Unmarshal: %v", err)
		http.Error(w, "Gagal parsing response database", http.StatusInternalServerError) // ✅ pesan berbeda
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Student created successfully",
		Data:    result[0],
	})
}
