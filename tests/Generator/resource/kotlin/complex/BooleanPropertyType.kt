
import com.fasterxml.jackson.annotation.*

/**
 * Represents a boolean value
 */
open class BooleanPropertyType : ScalarPropertyType {
    @JsonProperty("type")
    var type: String? = "boolean"
}

