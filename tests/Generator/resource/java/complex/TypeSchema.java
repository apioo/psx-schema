
import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * TypeSchema specification
 */
public class TypeSchema {
    private java.util.Map<String, String> _import;
    private java.util.Map<String, DefinitionType> definitions;
    private String root;

    @JsonSetter("import")
    public void setImport(java.util.Map<String, String> _import) {
        this._import = _import;
    }

    @JsonGetter("import")
    public java.util.Map<String, String> getImport() {
        return this._import;
    }

    @JsonSetter("definitions")
    public void setDefinitions(java.util.Map<String, DefinitionType> definitions) {
        this.definitions = definitions;
    }

    @JsonGetter("definitions")
    public java.util.Map<String, DefinitionType> getDefinitions() {
        return this.definitions;
    }

    @JsonSetter("root")
    public void setRoot(String root) {
        this.root = root;
    }

    @JsonGetter("root")
    public String getRoot() {
        return this.root;
    }
}

