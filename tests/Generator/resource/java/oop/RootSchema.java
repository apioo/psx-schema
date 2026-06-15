
import com.fasterxml.jackson.annotation.*;

public class RootSchema {
    @JsonProperty("students")
    private StudentMap students;


    public void setStudents(StudentMap students) {
        this.students = students;
    }

    public StudentMap getStudents() {
        return this.students;
    }
}

