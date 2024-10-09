package Foo.Bar;

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class Import {
    private My.Import.StudentMap students;
    private My.Import.Student student;

    @JsonSetter("students")
    public void setStudents(My.Import.StudentMap students) {
        this.students = students;
    }

    @JsonGetter("students")
    public My.Import.StudentMap getStudents() {
        return this.students;
    }

    @JsonSetter("student")
    public void setStudent(My.Import.Student student) {
        this.student = student;
    }

    @JsonGetter("student")
    public My.Import.Student getStudent() {
        return this.student;
    }
}

package Foo.Bar;

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class MyMap extends My.Import.Student {
}
