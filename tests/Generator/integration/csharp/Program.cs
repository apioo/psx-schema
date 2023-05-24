
using System.Text.Json;

class Program
{
    static void Main()
    {
        string input = File.ReadAllText("../input.json");

        News news = JsonSerializer.Deserialize<News>(input);

        string output = JsonSerializer.Serialize<News>(news);

        File.WriteAllText("../output.json", output);
    }
}
