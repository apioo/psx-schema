open class Specification {
    @JsonProperty("import") var import: Map<String, String>? = null
    @JsonProperty("definitions") var definitions: Map<String, DefinitionType>? = null
    @JsonProperty("root") var root: String? = null
}

