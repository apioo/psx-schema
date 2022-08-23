package Foo.Bar;

import com.fasterxml.jackson.annotation.JsonProperty;
public class Import {
    private My.Import.StudentMap students;
    private My.Import.Student student;
    @JsonProperty("students")
    public void setStudents(My.Import.StudentMap students) {
        this.students = students;
    }
    @JsonProperty("students")
    public My.Import.StudentMap getStudents() {
        return this.students;
    }
    @JsonProperty("student")
    public void setStudent(My.Import.Student student) {
        this.student = student;
    }
    @JsonProperty("student")
    public My.Import.Student getStudent() {
        return this.student;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("students", this.students);
        map.put("student", this.student);
        return map;
    }
}

package Foo.Bar;

import com.fasterxml.jackson.annotation.JsonProperty;
public class MyMap extends My.Import.Student {
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        return map;
    }
}
