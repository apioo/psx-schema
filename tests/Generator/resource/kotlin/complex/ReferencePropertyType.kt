/**
 * Represents a reference to a definition type
 */
open class ReferencePropertyType : PropertyType {
    @JsonProperty("type") var type: String? = null
    @JsonProperty("target") var target: String? = null
}

