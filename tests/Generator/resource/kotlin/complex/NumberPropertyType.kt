
import com.fasterxml.jackson.annotation.*

/**
 * Represents a float value
 */
open class NumberPropertyType : ScalarPropertyType {
    @JsonProperty("type")
    var type: String? = "number"
}

