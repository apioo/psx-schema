public static class Import {
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
}

public static class MyMap extends Student {
}
