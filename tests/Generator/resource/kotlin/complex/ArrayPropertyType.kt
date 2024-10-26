/**
 * Represents an array which contains a dynamic list of values
 */
open class ArrayPropertyType : CollectionPropertyType {
    @JsonProperty("type") var type: String? = null
}

