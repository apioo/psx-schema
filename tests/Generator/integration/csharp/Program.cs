
using System.Text.Json;

class Program
{
    static void Main()
    {
        string fileName = "../input.json";
        string input = File.ReadAllText(fileName);

        News news = JsonSerializer.Deserialize<News>(input);

        string output = JsonSerializer.Serialize<News>(news);

        Console.WriteLine(output);
    }
}
