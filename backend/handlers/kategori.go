package handlers

import (
	"encoding/json"
	"log"
	"net/http"

	"pengaduan/database"
	"pengaduan/models"
)

// GetAllKategori retrieves all categories
func GetAllKategori(w http.ResponseWriter, r *http.Request) {
	var kategoriList []models.Kategori
	data, _, err := database.DB.From("kategori").
		Select("id_kategori, ket_kategori", "exact", false).
		Execute()
	if err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	if err := json.Unmarshal(data, &kategoriList); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Categories retrieved",
		Data:    kategoriList,
	})
}

// CreateKategori creates a new category
func CreateKategori(w http.ResponseWriter, r *http.Request) {
	var kategori models.Kategori
	err := json.NewDecoder(r.Body).Decode(&kategori)
	if err != nil {
		log.Printf("Error Decode JSON: %v", err)
		http.Error(w, "Invalid request payload", http.StatusBadRequest)
		return
	}

	var result []models.Kategori
	data, _, err := database.DB.From("kategori").
		Insert(map[string]interface{}{
			"ket_kategori": kategori.KetKategori,
		}, false, "", "", "").
		Execute()
	if err != nil {
		http.Error(w, "Failed to create category", http.StatusInternalServerError)
		return
	}

	if err := json.Unmarshal(data, &result); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}
	if len(result) > 0 {
		kategori.ID = result[0].ID
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Category created successfully",
		Data:    kategori,
	})
}
