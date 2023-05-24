package main;

import "os"
import "encoding/json"
import "fmt"

func main() {
    data, err := os.ReadFile("../input.json")
    if err != nil {
        panic(err)
    }

    var news News
    err = json.Unmarshal(data, &news)

    raw, err := json.Marshal(news)
    if err != nil {
        panic(err)
    }

    fmt.Println(string(raw))
}
