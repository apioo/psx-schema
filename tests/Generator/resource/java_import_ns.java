package Foo.Bar;
public class Import {
    private My.Import.StudentMap students;
    private My.Import.Student student;
    public void setStudents(My.Import.StudentMap students) {
        this.students = students;
    }
    public My.Import.StudentMap getStudents() {
        return this.students;
    }
    public void setStudent(My.Import.Student student) {
        this.student = student;
    }
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
public class MyMap extends My.Import.Student {
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        return map;
    }
}
