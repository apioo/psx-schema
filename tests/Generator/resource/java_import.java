import com.fasterxml.jackson.annotation.JsonProperty;
public class Import {
    private StudentMap students;
    private Student student;
    @JsonProperty("students")
    public void setStudents(StudentMap students) {
        this.students = students;
    }
    @JsonProperty("students")
    public StudentMap getStudents() {
        return this.students;
    }
    @JsonProperty("student")
    public void setStudent(Student student) {
        this.student = student;
    }
    @JsonProperty("student")
    public Student getStudent() {
        return this.student;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("students", this.students);
        map.put("student", this.student);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;
public class MyMap extends Student {
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        return map;
    }
}
