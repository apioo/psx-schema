import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class Import {
    private StudentMap students;
    private Student student;
    @JsonSetter("students")
    public void setStudents(StudentMap students) {
        this.students = students;
    }
    @JsonGetter("students")
    public StudentMap getStudents() {
        return this.students;
    }
    @JsonSetter("student")
    public void setStudent(Student student) {
        this.student = student;
    }
    @JsonGetter("student")
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

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class MyMap extends Student {
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        return map;
    }
}
