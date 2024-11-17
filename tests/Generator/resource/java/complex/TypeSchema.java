package org.typeapi.model;

import com.fasterxml.jackson.annotation.*;

/**
 * TypeSchema specification
 */
public class TypeSchema {
    private java.util.Map<String, DefinitionType> definitions;
    private java.util.Map<String, String> _import;
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

