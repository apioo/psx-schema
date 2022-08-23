public class Import {
    private StudentMap students;
    private Student student;
    public void setStudents(StudentMap students) {
        this.students = students;
    }
    public StudentMap getStudents() {
        return this.students;
    }
    public void setStudent(Student student) {
        this.student = student;
    }
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

public class MyMap extends Student {
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        return map;
    }
}
