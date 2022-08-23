import com.fasterxml.jackson.annotation.JsonProperty;
public class Human {
    private String firstName;
    @JsonProperty("firstName")
    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }
    @JsonProperty("firstName")
    public String getFirstName() {
        return this.firstName;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("firstName", this.firstName);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;
public class Student extends Human {
    private String matricleNumber;
    @JsonProperty("matricleNumber")
    public void setMatricleNumber(String matricleNumber) {
        this.matricleNumber = matricleNumber;
    }
    @JsonProperty("matricleNumber")
    public String getMatricleNumber() {
        return this.matricleNumber;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("matricleNumber", this.matricleNumber);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;
public class StudentMap extends Map<Student> {
}

import com.fasterxml.jackson.annotation.JsonProperty;
public class Map<T> {
    private int totalResults;
    private T[] entries;
    @JsonProperty("totalResults")
    public void setTotalResults(int totalResults) {
        this.totalResults = totalResults;
    }
    @JsonProperty("totalResults")
    public int getTotalResults() {
        return this.totalResults;
    }
    @JsonProperty("entries")
    public void setEntries(T[] entries) {
        this.entries = entries;
    }
    @JsonProperty("entries")
    public T[] getEntries() {
        return this.entries;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("totalResults", this.totalResults);
        map.put("entries", this.entries);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;
public class RootSchema {
    private StudentMap students;
    @JsonProperty("students")
    public void setStudents(StudentMap students) {
        this.students = students;
    }
    @JsonProperty("students")
    public StudentMap getStudents() {
        return this.students;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("students", this.students);
        return map;
    }
}
