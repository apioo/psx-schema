package main;

import "os"
import "encoding/json"
import "fmt"

func main() {
    input, err := os.ReadFile("../input.json")
    if err != nil {
        panic(err)
    }

    var news News
    err = json.Unmarshal(input, &news)

    output, err := json.Marshal(news)
    if err != nil {
        panic(err)
    }

    err := os.WriteFile("../output.json", output, 0644)
    if err != nil {
        panic(err)
    }
}
