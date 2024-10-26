/**
 * Represents a string value
 */
open class StringPropertyType : ScalarPropertyType {
    @JsonProperty("type") var type: String? = null
    @JsonProperty("format") var format: String? = null
}

