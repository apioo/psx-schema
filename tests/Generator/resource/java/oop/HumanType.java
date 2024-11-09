
import com.fasterxml.jackson.annotation.*;

public class HumanType {
    private String firstName;
    private HumanType parent;

    @JsonSetter("firstName")
    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    @JsonGetter("firstName")
    public String getFirstName() {
        return this.firstName;
    }

    @JsonSetter("parent")
    public void setParent(HumanType parent) {
        this.parent = parent;
    }

    @JsonGetter("parent")
    public HumanType getParent() {
        return this.parent;
    }
}

