package Foo.Bar;
public static class Import {
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
}

package Foo.Bar;
public static class MyMap extends My.Import.Student {
}
