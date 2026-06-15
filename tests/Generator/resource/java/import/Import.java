
import com.fasterxml.jackson.annotation.*;

public class Import {
    @JsonProperty("students")
    private StudentMap students;

    @JsonProperty("student")
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

