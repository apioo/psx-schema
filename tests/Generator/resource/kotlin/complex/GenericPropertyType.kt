
import com.fasterxml.jackson.annotation.*

/**
 * Represents a generic value which can be replaced with a concrete type
 */
open class GenericPropertyType : PropertyType {
    @JsonProperty("name")
    var name: String? = null
    @JsonProperty("type")
    var type: String? = "generic"
}

