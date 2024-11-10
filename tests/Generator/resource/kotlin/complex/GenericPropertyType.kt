
import com.fasterxml.jackson.annotation.*
/**
 * Represents a generic value which can be replaced with a dynamic type
 */
open class GenericPropertyType : PropertyType {
    @JsonProperty("name") var name: String? = null
}

