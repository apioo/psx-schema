
import com.fasterxml.jackson.annotation.*;

public class Student extends HumanType {
    private String matricleNumber;

    @JsonSetter("matricleNumber")
    public void setMatricleNumber(String matricleNumber) {
        this.matricleNumber = matricleNumber;
    }

    @JsonGetter("matricleNumber")
    public String getMatricleNumber() {
        return this.matricleNumber;
    }
}

