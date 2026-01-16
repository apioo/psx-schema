
import com.fasterxml.jackson.annotation.*

/**
 * Represents an integer value
 */
open class IntegerPropertyType : ScalarPropertyType {
    @JsonProperty("type")
    var type: String? = "integer"
}

