package database

import (
	"fmt"
	"os"

	"github.com/supabase-community/supabase-go"
)

var DB *supabase.Client

func Init() error {
	supabaseURL := os.Getenv("SUPABASE_URL")
	supabaseKey := os.Getenv("SUPABASE_KEY")

	client, err := supabase.NewClient(supabaseURL, supabaseKey, &supabase.ClientOptions{})
	if err != nil {
		return fmt.Errorf("failed to initialize supabase client: %w", err)
	}

	DB = client
	return nil
}