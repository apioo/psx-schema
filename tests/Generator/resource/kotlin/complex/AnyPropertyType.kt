/**
 * Represents an any value which allows any kind of value
 */
open class AnyPropertyType : PropertyType {
    @JsonProperty("type") var type: String? = null
}

