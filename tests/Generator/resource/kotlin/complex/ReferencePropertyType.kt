/**
 * Represents a reference to a definition type
 */
open class ReferencePropertyType : PropertyType {
    @JsonProperty("target") var target: String? = null
    @JsonProperty("template") var template: Map<String, String>? = null
}

