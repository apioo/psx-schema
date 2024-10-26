
import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

public class Human {
    private String firstName;
    private Human parent;

    @JsonSetter("firstName")
    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    @JsonGetter("firstName")
    public String getFirstName() {
        return this.firstName;
    }

    @JsonSetter("parent")
    public void setParent(Human parent) {
        this.parent = parent;
    }

    @JsonGetter("parent")
    public Human getParent() {
        return this.parent;
    }
}

