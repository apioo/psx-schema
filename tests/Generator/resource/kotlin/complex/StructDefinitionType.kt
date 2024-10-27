/**
 * A struct represents a class/structure with a fix set of defined properties.
 */
open class StructDefinitionType : DefinitionType {
    @JsonProperty("parent") var parent: ReferencePropertyType? = null
    @JsonProperty("base") var base: Boolean? = null
    @JsonProperty("properties") var properties: Map<String, PropertyType>? = null
    @JsonProperty("discriminator") var discriminator: String? = null
    @JsonProperty("mapping") var mapping: Map<String, String>? = null
}

