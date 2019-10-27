package main
import (
  "fmt"
  "github.com/gorilla/mux"
  //"github.com/davecgh/go-spew/spew"
  "net/http"
  "encoding/json"
  "io/ioutil"
  "time"
  "math/rand"
)

/**
 * Counter structure - To capture the count variable being passed to the API
 */
type Counter struct {
	Count int `json:"count"`
}

/**
 * charactersInEpisode function - Will send a character into the office (channel) at random
 */
func characterInEpisode(the_office chan string) {
	// Sleep for 1 second (check)
	time.Sleep(1 * time.Second)

	// Create slice for the list of random characters
	characters := make([]string, 0)
    characters = append(characters,
		"Michael Scott",
		"Dwight Schrute",
		"Jim Halpert",
		"Pam Beesly",
		"Ryan Howard",
		"Andy Bernard",
		"Robert California",
		"Jan Levinson",
		"Roy Anderson",
		"Stanley Hudson",
		"Kevin Malone",
		"Meredith Palmer",
		"Angela Martin",
		"Oscar Martinez",
		"Phyllis Lapin",
		"Kelly Kapoor",
		"Toby Flenderson",
		"Creed Bratton",
		"Darryl Philbin",
		"Erin Hannon",
		"Gabe Lewis",
		"Holly Flax",
		"Nellie Bertram",
		"Clark Green",
		"Pete Miller",
		"Jo Bennett",
		"Karen Fillippelli",
		"Holly Flax",
		"Ed Truck",
		"Josh Porter",
	)

    // Send a random string (character) to the channel (the office)
	the_office <- characters[rand.Intn(len(characters))]
}

/**
 * countToX function - Will evaluate POST parameters to extract a number, call a goroutine
 *                     to get a random Office character X number of times, 
 *                     and return successful message
 */
func countToX(w http.ResponseWriter, r *http.Request) {
	// Read Post JSON Body
	body, err := ioutil.ReadAll(r.Body)
	defer r.Body.Close()

	// If there is an error in getting the Body, return 500
	if err != nil {
		http.Error(w, err.Error(), 500)
		return
	}

	// Decode the JSON from the POST Body
	var counter Counter
	err = json.Unmarshal(body, &counter)

	// If extracting the values errored, return 500
	if err != nil {
		http.Error(w, err.Error(), 500)
		return
	}

	// Define channel
	the_office := make(chan string)

	for i := 0; i < counter.Count; i++ {
		// Call goroutine (check)
		go characterInEpisode(the_office)
		// Output from channel (check)
		fmt.Println(<-the_office)
	}

	// Close channel
	close(the_office)

	// Output some message of success
	fmt.Fprintf(w, "The office is open with %d employees", counter.Count)
}

/**
 * gracefulFailure function - Will return a custom message is page is not found that is on theme
 */
func gracefulFailure(w http.ResponseWriter, r *http.Request) {
	fmt.Fprintf(w, "ANSWERING MACHINE: The office is closed today for the Michael Scott's Dunder Mifflin Scranton Meredith Palmer Memorial Celebrity Rabies Awareness Pro-am Fun Run Race For The Cure. Please try again another time.")
}


func main() {
  router := mux.NewRouter()

  // Our count-to-x path
  router.HandleFunc("/count-to-x", countToX).Methods("POST")

  router.NotFoundHandler = http.HandlerFunc(gracefulFailure)

  // Reject all others gracefully

  http.ListenAndServe(":8000", router)
}