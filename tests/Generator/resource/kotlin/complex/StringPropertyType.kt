
import com.fasterxml.jackson.annotation.*

/**
 * Represents a string value
 */
open class StringPropertyType : ScalarPropertyType {
    @JsonProperty("default")
    var default: String? = null
    @JsonProperty("format")
    var format: String? = null
    @JsonProperty("type")
    var type: String? = "string"
}

