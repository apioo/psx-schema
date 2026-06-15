package Foo.Bar;

import com.fasterxml.jackson.annotation.*;

public class Import {
    @JsonProperty("students")
    private My.Import.StudentMap students;

    @JsonProperty("student")
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

