import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;
public class Human {
    private String firstName;
    private Human parent;
    @JsonSetter("firstName")
    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }
    @JsonGetter("firstName")
    public String getFirstName() {
        return this.firstName;
    }
    @JsonSetter("parent")
    public void setParent(Human parent) {
        this.parent = parent;
    }
    @JsonGetter("parent")
    public Human getParent() {
        return this.parent;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;
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
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;
public class StudentMap extends Map<Student> {
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;
public class Map<T> {
    private Integer totalResults;
    private List<T> entries;
    @JsonSetter("totalResults")
    public void setTotalResults(Integer totalResults) {
        this.totalResults = totalResults;
    }
    @JsonGetter("totalResults")
    public Integer getTotalResults() {
        return this.totalResults;
    }
    @JsonSetter("entries")
    public void setEntries(List<T> entries) {
        this.entries = entries;
    }
    @JsonGetter("entries")
    public List<T> getEntries() {
        return this.entries;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.util.List;
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
}
