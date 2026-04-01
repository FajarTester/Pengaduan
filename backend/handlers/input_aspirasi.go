package handlers

import (
	"encoding/json"
	"log"
	"net/http"
	"strconv"

	//! Nama Project: Pengaduan
	"pengaduan/database"
	"pengaduan/models"

	"github.com/gorilla/mux"
)

// ! ----Input Aspirasi -----------
func GetAllInputAspirasi(w http.ResponseWriter, r *http.Request) {
	var InputAspirasiList []models.InputAspirasi
	data, _, err := database.DB.From("input_aspirasi").
		Select("id_pelaporan, nis, id_kategori, lokasi, ket", "exact", false).
		Execute()
	if err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	if err := json.Unmarshal(data, &InputAspirasiList); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Reports retrieved",
		Data:    InputAspirasiList,
	})
}

func GetInputAspirasiByNIS(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)
	nis := vars["nis"]
	if nis == "" {
		http.Error(w, "Invalid NIS", http.StatusBadRequest)
		return
	}

	var InputAspirasiList []models.InputAspirasi
	data, _, err := database.DB.From("input_aspirasi").
		Select("id_pelaporan, nis, id_kategori, lokasi, ket", "exact", false).
		Eq("nis", nis). // ✅ langsung string
		Execute()
	if err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	if err := json.Unmarshal(data, &InputAspirasiList); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Reports retrieved",
		Data:    InputAspirasiList,
	})
}

func GetInputAspirasiByID(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)
	id, err := strconv.Atoi(vars["id"])
	if err != nil {
		http.Error(w, "Invalid ID", http.StatusBadRequest)
		return
	}

	var InputAspirasi models.InputAspirasi
	data, _, err := database.DB.From("input_aspirasi").
		Select("id_pelaporan, nis, id_kategori, lokasi, ket", "exact", false).
		Eq("id_pelaporan", strconv.Itoa(id)).
		Single().
		Execute()
	if err != nil {
		http.Error(w, "Report not found", http.StatusNotFound)
		return
	}

	if err := json.Unmarshal(data, &InputAspirasi); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Report found",
		Data:    InputAspirasi,
	})
}
func CreateInputAspirasi(w http.ResponseWriter, r *http.Request) {
	var InputAspirasi models.InputAspirasi

	if err := json.NewDecoder(r.Body).Decode(&InputAspirasi); err != nil {
		log.Printf("Error Decode JSON: %v", err)
		http.Error(w, "Invalid request payload", http.StatusBadRequest)
		return
	}

	requestBodyJSON, _ := json.Marshal(InputAspirasi)
	log.Printf("[POST] CreateInputAspirasi - Request Body: %s", string(requestBodyJSON))

	var existingData []models.InputAspirasi
	checkData, _, err := database.DB.From("input_aspirasi").
		Select("id_pelaporan, nis, id_kategori, lokasi, ket", "exact", false).
		Eq("nis", InputAspirasi.NIS).
		Eq("id_kategori", strconv.Itoa(InputAspirasi.IDKategori)).
		Eq("lokasi", InputAspirasi.Lokasi).
		Eq("ket", InputAspirasi.Ket).
		Execute()

	if err == nil {
		if err := json.Unmarshal(checkData, &existingData); err == nil {
			if len(existingData) > 0 {
				log.Printf("[POST] Duplicate detected - ignoring insert. Existing ID: %d", existingData[0].IDPelaporan)
				w.Header().Set("Content-Type", "application/json")
				json.NewEncoder(w).Encode(models.Response{
					Success: true,
					Message: "Report already exists",
					Data:    existingData[0],
				})
				return
			}
		}
	}

	var result []models.InputAspirasi
	data, _, err := database.DB.From("input_aspirasi").
		Insert(map[string]interface{}{
			"nis":         InputAspirasi.NIS, // ✅ langsung string
			"id_kategori": InputAspirasi.IDKategori,
			"lokasi":      InputAspirasi.Lokasi,
			"ket":         InputAspirasi.Ket,
		}, false, "", "", "").
		Execute()
	if err != nil {
		http.Error(w, "Gagal menyimpan data", http.StatusInternalServerError)
		return
	}

	if err := json.Unmarshal(data, &result); err != nil {
		http.Error(w, "Gagal parsing response", http.StatusInternalServerError)
		return
	}

	if len(result) > 0 {
		InputAspirasi.IDPelaporan = result[0].IDPelaporan
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Report created successfully",
		Data:    InputAspirasi,
	})
}

// UpdateInputAspirasi updates a report
func UpdateInputAspirasi(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)
	id := vars["id"]

	var InputAspirasi models.InputAspirasi
	if err := json.NewDecoder(r.Body).Decode(&InputAspirasi); err != nil {
		log.Printf("Error Decode JSON: %v", err)
		http.Error(w, "Invalid JSON", http.StatusBadRequest)
		return
	}

	// Log request body
	requestBodyJSON, _ := json.Marshal(InputAspirasi)
	log.Printf("[PUT] UpdateInputAspirasi - ID: %s, Request Body: %s", id, string(requestBodyJSON))

	data, _, err := database.DB.From("input_aspirasi").
		Update(map[string]interface{}{
			"lokasi": InputAspirasi.Lokasi,
			"ket":    InputAspirasi.Ket,
		}, "", "representation").
		Eq("id_pelaporan", id).
		Execute()

	if err != nil {
		log.Printf("DATABASE ERROR (Update): %v", err) // INI PENTING
		http.Error(w, "Gagal update: "+err.Error(), http.StatusInternalServerError)
		return
	}

	// Cek apakah ada data yang benar-benar terupdate
	if string(data) == "[]" || string(data) == "null" {
		log.Printf("Update failed: ID %s tidak ditemukan", id)
		http.Error(w, "Data tidak ditemukan", http.StatusNotFound)
		return
	}

	log.Printf("Update Success for ID: %s", id)
	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Report updated successfully",
	})
}

// DeleteInputAspirasi deletes a report
func DeleteInputAspirasi(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)

	id, err := strconv.Atoi(vars["id"])
	if err != nil {
		http.Error(w, "Invalid ID", http.StatusBadRequest)
		return
	}

	_, _, err = database.DB.From("input_aspirasi").
		Delete("", "").
		Eq("id_pelaporan", strconv.Itoa(id)).
		Execute()
	if err != nil {
		http.Error(w, "Failed to delete report", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Report deleted successfully",
	})
}
