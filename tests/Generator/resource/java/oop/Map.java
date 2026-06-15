
import com.fasterxml.jackson.annotation.*;

public class Map<P, T> {
    @JsonProperty("totalResults")
    private Integer totalResults;

    @JsonProperty("parent")
    private P parent;

    @JsonProperty("entries")
    private java.util.List<T> entries;


    public void setTotalResults(Integer totalResults) {
        this.totalResults = totalResults;
    }

    public Integer getTotalResults() {
        return this.totalResults;
    }

    public void setParent(P parent) {
        this.parent = parent;
    }

    public P getParent() {
        return this.parent;
    }

    public void setEntries(java.util.List<T> entries) {
        this.entries = entries;
    }

    public java.util.List<T> getEntries() {
        return this.entries;
    }
}

