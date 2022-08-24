import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class Human {
    private String firstName;
    @JsonSetter("firstName")
    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }
    @JsonGetter("firstName")
    public String getFirstName() {
        return this.firstName;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("firstName", this.firstName);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class Student extends Human {
    private String matricleNumber;
    @JsonSetter("matricleNumber")
    public void setMatricleNumber(String matricleNumber) {
        this.matricleNumber = matricleNumber;
    }
    @JsonGetter("matricleNumber")
    public String getMatricleNumber() {
        return this.matricleNumber;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("matricleNumber", this.matricleNumber);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class StudentMap extends Map<Student> {
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class Map<T> {
    private int totalResults;
    private T[] entries;
    @JsonSetter("totalResults")
    public void setTotalResults(int totalResults) {
        this.totalResults = totalResults;
    }
    @JsonGetter("totalResults")
    public int getTotalResults() {
        return this.totalResults;
    }
    @JsonSetter("entries")
    public void setEntries(T[] entries) {
        this.entries = entries;
    }
    @JsonGetter("entries")
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class RootSchema {
    private StudentMap students;
    @JsonSetter("students")
    public void setStudents(StudentMap students) {
        this.students = students;
    }
    @JsonGetter("students")
    public StudentMap getStudents() {
        return this.students;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("students", this.students);
        return map;
    }
}
