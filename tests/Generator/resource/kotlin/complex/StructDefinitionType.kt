/**
 * Represents a struct which contains a fixed set of defined properties
 */
open class StructDefinitionType : DefinitionType {
    @JsonProperty("type") var type: String? = null
    @JsonProperty("parent") var parent: String? = null
    @JsonProperty("base") var base: Boolean? = null
    @JsonProperty("properties") var properties: Map<String, PropertyType>? = null
    @JsonProperty("discriminator") var discriminator: String? = null
    @JsonProperty("mapping") var mapping: Map<String, String>? = null
    @JsonProperty("template") var template: Map<String, String>? = null
}

