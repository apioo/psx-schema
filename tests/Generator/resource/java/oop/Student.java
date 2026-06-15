
import com.fasterxml.jackson.annotation.*;

public class Student extends HumanType {
    @JsonProperty("matricleNumber")
    private String matricleNumber;


    public void setMatricleNumber(String matricleNumber) {
        this.matricleNumber = matricleNumber;
    }

    public String getMatricleNumber() {
        return this.matricleNumber;
    }
}

