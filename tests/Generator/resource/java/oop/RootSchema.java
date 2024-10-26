
import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

public class RootSchema {
    private StudentMap students;

    @JsonSetter("students")
    public void setStudents(StudentMap students) {
        this.students = students;
    }

    @JsonGetter("students")
    public StudentMap getStudents() {
        return this.students;
    }
}

