/**
 * Represents a string value
 */
open class StringPropertyType : ScalarPropertyType {
    @JsonProperty("format") var format: String? = null
}

