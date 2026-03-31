package handlers

import (
	"encoding/json"
	"net/http"

	"pengaduan/database"
	"pengaduan/models"

	"golang.org/x/crypto/bcrypt"
)

// Login handles admin login
func Login(w http.ResponseWriter, r *http.Request) {
	var admin models.Admin
	err := json.NewDecoder(r.Body).Decode(&admin)
	if err != nil {
		http.Error(w, "Invalid request", http.StatusBadRequest)
		return
	}

	var storedAdmin models.Admin
	data, _, err := database.DB.From("admin").
		Select("username, password", "exact", false).
		Eq("username", admin.Username).
		Single().
		Execute()
	if err != nil {
		http.Error(w, "User not found", http.StatusUnauthorized)
		return
	}

	if err := json.Unmarshal(data, &storedAdmin); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	err = bcrypt.CompareHashAndPassword([]byte(storedAdmin.Password), []byte(admin.Password))
	if err != nil {
		http.Error(w, "Invalid password", http.StatusUnauthorized)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Login successful",
		Data: models.AdminResponse{
			Username: admin.Username,
		},
	})
}

// Register handles admin registration
func Register(w http.ResponseWriter, r *http.Request) {
	var admin models.Admin
	err := json.NewDecoder(r.Body).Decode(&admin)
	if err != nil {
		http.Error(w, "Invalid request", http.StatusBadRequest)
		return
	}

	hashedPassword, err := bcrypt.GenerateFromPassword([]byte(admin.Password), bcrypt.DefaultCost)
	if err != nil {
		http.Error(w, "Internal server error", http.StatusInternalServerError)
		return
	}

	var result []models.Admin
	data, _, err := database.DB.From("admin").
		Insert(map[string]interface{}{
			"username": admin.Username,
			"password": string(hashedPassword),
		}, false, "", "", "").
		Execute()
	if err != nil {
		http.Error(w, "Username already exists", http.StatusConflict)
		return
	}

	if err := json.Unmarshal(data, &result); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Registration successful",
	})
}
