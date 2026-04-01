package handlers

import (
	"encoding/json"
	"log"
	"net/http"

	"pengaduan/database"
	"pengaduan/models"

	"github.com/gorilla/mux"
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
			Username: storedAdmin.Username,
		},
	})
}

func GetAdminByEmail(w http.ResponseWriter, r *http.Request) {
	email := r.URL.Query().Get("email")
	if email == "" {
		http.Error(w, "Invalid email", http.StatusBadRequest)
		return
	}

	var admin models.Admin
	data, _, err := database.DB.From("admin").
		Select("email, username, password", "exact", false).
		Eq("email", email).
		Single().
		Execute()
	if err != nil {
		http.Error(w, "Admin not found", http.StatusNotFound)
		return
	}

	if err := json.Unmarshal(data, &admin); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Admin found",
		Data:    admin,
	})
}

func GetAdminByID(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)
	id := vars["id"]
	if id == "" {
		http.Error(w, "Invalid ID", http.StatusBadRequest)
		return
	}

	var admin models.Admin
	data, _, err := database.DB.From("admin").
		Select("email, username, password", "exact", false).
		Eq("id", id).
		Single().
		Execute()
	if err != nil {
		http.Error(w, "Admin not found", http.StatusNotFound)
		return
	}

	if err := json.Unmarshal(data, &admin); err != nil {
		http.Error(w, "Gagal parsing data", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(models.Response{
		Success: true,
		Message: "Admin found",
		Data:    admin,
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

	log.Printf("[POST] Register - Attempt for Email: %s", admin.Email)

	hashedPassword, err := bcrypt.GenerateFromPassword([]byte(admin.Password), bcrypt.DefaultCost)
	if err != nil {
		http.Error(w, "Internal server error", http.StatusInternalServerError)
		return
	}
	_, _, err = database.DB.From("admin").
		Insert(map[string]interface{}{
			"email":    admin.Email,
			"username": admin.Username,
			"password": string(hashedPassword),
		}, false, "", "representation", "").
		Execute()

	if err != nil {

		log.Printf("Database Error: %v", err)
		http.Error(w, "Registration failed (email might exist)", http.StatusConflict)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(http.StatusCreated)
	json.NewEncoder(w).Encode(map[string]interface{}{
		"success": true,
		"message": "Registration successful",
	})
}
