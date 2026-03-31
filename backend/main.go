package handler

import (
	"fmt"
	"log"
	"net/http"
	"os"

	"github.com/gorilla/mux"
	"github.com/joho/godotenv"

	"pengaduan/database"
	"pengaduan/handlers"
)

func init() {
	_ = godotenv.Load()

	err := database.Init()
	if err != nil {
		log.Println("Database connection failed:", err)
	}
}

func loggingMiddleware(next http.Handler) http.Handler {
	return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		log.Printf("Request: %s %s %s", r.Method, r.RequestURI, r.RemoteAddr)
		next.ServeHTTP(w, r)
	})
}

// Handler adalah fungsi utama yang dipanggil oleh Vercel
func Handler(w http.ResponseWriter, r *http.Request) {
	router := setupRouter()
	router.ServeHTTP(w, r)
}

// setupRouter memisahkan logika routing agar rapi
func setupRouter() *mux.Router {
	router := mux.NewRouter()
	router.Use(mux.CORSMethodMiddleware(router))
	router.Use(loggingMiddleware)

	// Auth endpoints
	router.HandleFunc("/api/auth/login", handlers.Login).Methods("POST")
	router.HandleFunc("/api/auth/register", handlers.Register).Methods("POST")

	// Siswa endpoints
	router.HandleFunc("/api/siswa/{nis}", handlers.GetSiswaByNIS).Methods("GET")
	router.HandleFunc("/api/siswa", handlers.GetAllSiswa).Methods("GET")
	router.HandleFunc("/api/siswa", handlers.CreateSiswa).Methods("POST")

	// Kategori endpoints
	router.HandleFunc("/api/kategori", handlers.GetAllKategori).Methods("GET")
	router.HandleFunc("/api/kategori", handlers.CreateKategori).Methods("POST")

	// Aspirasi endpoints
	router.HandleFunc("/api/aspirasi", handlers.GetAllAspirasi).Methods("GET")
	router.HandleFunc("/api/aspirasi/{id}", handlers.GetAspirationByID).Methods("GET")
	router.HandleFunc("/api/aspirasi", handlers.CreateAspirasi).Methods("POST")
	router.HandleFunc("/api/aspirasi/{id}", handlers.UpdateAspirasi).Methods("PUT")

	// Pengaduan endpoints
	router.HandleFunc("/api/input_aspirasi/siswa/{nis}", handlers.GetInputAspirasiByNIS).Methods("GET")
	router.HandleFunc("/api/input_aspirasi", handlers.GetAllInputAspirasi).Methods("GET")
	router.HandleFunc("/api/input_aspirasi", handlers.CreateInputAspirasi).Methods("POST")
	router.HandleFunc("/api/input_aspirasi/{id}", handlers.GetInputAspirasiByID).Methods("GET")
	router.HandleFunc("/api/input_aspirasi/{id}", handlers.UpdateInputAspirasi).Methods("PUT")
	router.HandleFunc("/api/input_aspirasi/{id}", handlers.DeleteInputAspirasi).Methods("DELETE")

	return router
}

// main tetap ada agar kamu bisa menjalankan 'go run main.go' secara lokal
func main() {
	router := setupRouter()
	port := os.Getenv("API_PORT")
	if port == "" {
		port = "8080"
	}

	fmt.Printf("API Server running on port %s\n", port)
	log.Fatal(http.ListenAndServe(":"+port, router))
}
