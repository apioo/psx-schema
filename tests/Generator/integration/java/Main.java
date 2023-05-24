package org.phpsx.test;

public class Main {
    public static void main(String[] args) {
        String input = Files.readString("../input.json");

        ObjectMapper objectMapper = new ObjectMapper();

        News data = objectMapper.readValue(input, News.class);

        String output = objectMapper.writeValueAsString(data)

        Files.write("../output.json", output);
    }
}
