
import com.fasterxml.jackson.annotation.*;

public class HumanType {
    @JsonProperty("firstName")
    private String firstName;

    @JsonProperty("parent")
    private HumanType parent;


    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public String getFirstName() {
        return this.firstName;
    }

    public void setParent(HumanType parent) {
        this.parent = parent;
    }

    public HumanType getParent() {
        return this.parent;
    }
}

