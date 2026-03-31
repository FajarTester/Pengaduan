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

// ! ---- Aspirasi -----------
func GetAllAspirasi(w http.ResponseWriter, r *http.Request) {
	var aspirasiList []models.Aspirasi
	data, _, err := database.DB.From("aspirasi").
		Select("id_aspirasi, id_pelaporan, status, id_kategori, feedback", "exact", false).
		Execute()

	if err != nil {
		http.Error(w, "Database error: "+err.Error(), http.StatusInternalServerError)
		return
	}

	if err := json.Unmarshal(data, &aspirasiList); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Aspirations retrieved",
		Data:    aspirasiList,
	})
}

func GetAspirationByID(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)
	id, err := strconv.Atoi(vars["id"])
	if err != nil {
		http.Error(w, "Invalid ID", http.StatusBadRequest)
		return
	}

	var aspirasi models.Aspirasi
	data, _, err := database.DB.From("aspirasi").
		Select("id_aspirasi, id_pelaporan, status, id_kategori, feedback", "exact", false).
		Eq("id_aspirasi", strconv.Itoa(id)).
		Single().
		Execute()
	if err != nil {
		http.Error(w, "Aspiration not found", http.StatusNotFound)
		return
	}

	if err := json.Unmarshal(data, &aspirasi); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Aspiration found",
		Data:    aspirasi,
	})
}

func CreateAspirasi(w http.ResponseWriter, r *http.Request) {
	var aspirasi models.Aspirasi
	if err := json.NewDecoder(r.Body).Decode(&aspirasi); err != nil {
		http.Error(w, "Invalid request payload", http.StatusBadRequest)
		return
	}

	if aspirasi.Status == "" {
		aspirasi.Status = "Menunggu"
	}

	requestBodyJSON, _ := json.Marshal(aspirasi)
	log.Printf("[POST] CreateAspirasi - ID: %d, Request Body: %s", aspirasi.IDPelaporan, string(requestBodyJSON))

	// Cek apakah sudah ada aspirasi untuk id_pelaporan ini
	existing, _, err := database.DB.From("aspirasi").
		Select("id_aspirasi", "exact", false).
		Eq("id_pelaporan", strconv.Itoa(aspirasi.IDPelaporan)).
		Execute()

	var existingList []models.Aspirasi
	json.Unmarshal(existing, &existingList)

	if err == nil && len(existingList) > 0 {
		// UPDATE - sudah ada
		_, _, err = database.DB.From("aspirasi").
			Update(map[string]interface{}{
				"status":      aspirasi.Status,
				"id_kategori": aspirasi.IDKategori,
				"feedback":    aspirasi.Feedback,
			}, "", "").
			Eq("id_pelaporan", strconv.Itoa(aspirasi.IDPelaporan)).
			Execute()
	} else {
		// INSERT - belum ada
		_, _, err := database.DB.From("aspirasi").
			Upsert(map[string]interface{}{
				"id_pelaporan": aspirasi.IDPelaporan,
				"status":       aspirasi.Status,
				"id_kategori":  aspirasi.IDKategori,
				"feedback":     aspirasi.Feedback,
			}, "id_pelaporan", "", "").
			Execute()

		if err != nil {
			log.Printf("Error database: %v", err)
			http.Error(w, "Database Error: "+err.Error(), http.StatusInternalServerError)
			return
		}
	}

	if err != nil {
		http.Error(w, "Failed: "+err.Error(), http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{Success: true, Message: "Review saved"})
}

// UpdateAspirasi updates an aspiration
func UpdateAspirasi(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)

	var aspirasi models.Aspirasi
	if err := json.NewDecoder(r.Body).Decode(&aspirasi); err != nil {
		http.Error(w, "Invalid payload", http.StatusBadRequest)
		return
	}

	_, _, err := database.DB.From("aspirasi").
		Update(map[string]interface{}{
			"status":   aspirasi.Status,
			"feedback": aspirasi.Feedback,
		}, "", "").
		Eq("id_aspirasi", vars["id"]).
		Execute()

	if err != nil {
		log.Printf("Error Update: %v", err)
		http.Error(w, "Failed to update: "+err.Error(), http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{Success: true, Message: "Updated!"})
}
