
import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

public class Map<P, T> {
    private Integer totalResults;
    private P parent;
    private java.util.List<T> entries;

    @JsonSetter("totalResults")
    public void setTotalResults(Integer totalResults) {
        this.totalResults = totalResults;
    }

    @JsonGetter("totalResults")
    public Integer getTotalResults() {
        return this.totalResults;
    }

    @JsonSetter("parent")
    public void setParent(P parent) {
        this.parent = parent;
    }

    @JsonGetter("parent")
    public P getParent() {
        return this.parent;
    }

    @JsonSetter("entries")
    public void setEntries(java.util.List<T> entries) {
        this.entries = entries;
    }

    @JsonGetter("entries")
    public java.util.List<T> getEntries() {
        return this.entries;
    }
}

