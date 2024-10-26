/**
 * Represents a generic value which can be replaced with a dynamic type
 */
open class GenericPropertyType : PropertyType {
    @JsonProperty("type") var type: String? = null
    @JsonProperty("name") var name: String? = null
}

