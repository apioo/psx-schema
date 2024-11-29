package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("TypeSchema specification")
public class TypeSchema {
    private java.util.Map<String, DefinitionType> definitions;
    @JsonPropertyDescription("Through the import keyword it is possible to import other TypeSchema documents. It contains a map where the key is the namespace and the value points to a remote document. The value is a URL and a code generator should support at least the following schemes: file, http, https.")
    private java.util.Map<String, String> _import;
    @JsonPropertyDescription("Specifies the root type of your specification.")
    private String root;

    @JsonSetter("definitions")
    public void setDefinitions(java.util.Map<String, DefinitionType> definitions) {
        this.definitions = definitions;
    }

    @JsonGetter("definitions")
    public java.util.Map<String, DefinitionType> getDefinitions() {
        return this.definitions;
    }

    @JsonSetter("import")
    public void setImport(java.util.Map<String, String> _import) {
        this._import = _import;
    }

    @JsonGetter("import")
    public java.util.Map<String, String> getImport() {
        return this._import;
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

