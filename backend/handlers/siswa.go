package handlers

import (
	"encoding/json"
	"log"
	"net/http"
	"strconv"

	"pengaduan/database"
	"pengaduan/models"

	"github.com/gorilla/mux"
)

func GetSiswaByNIS(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)
	nis, err := strconv.ParseInt(vars["nis"], 10, 64)
	if err != nil {
		http.Error(w, "Invalid NIS", http.StatusBadRequest)
		return
	}

	var siswa models.Siswa
	data, _, err := database.DB.From("siswa").
		Select("nis, kelas", "exact", false).
		Eq("nis", strconv.FormatInt(nis, 10)).
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

// CreateSiswa creates a new student
func CreateSiswa(w http.ResponseWriter, r *http.Request) {
	var siswa models.Siswa
	err := json.NewDecoder(r.Body).Decode(&siswa)
	if err != nil {
		log.Printf("Error Decode JSON: %v", err) // <--- TAMBAHKAN INI
		http.Error(w, "Invalid request payload", http.StatusBadRequest)
		return
	}

	var result []models.Siswa
	data, _, err := database.DB.From("siswa").
		Insert(map[string]interface{}{
			"nis":   siswa.NIS,
			"kelas": siswa.Kelas,
		}, false, "", "", "").
		Execute()
	if err != nil {
		http.Error(w, "Gagal parsing data", http.StatusConflict)
		return
	}

	if err := json.Unmarshal(data, &result); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Student created successfully",
		Data:    siswa,
	})
}
