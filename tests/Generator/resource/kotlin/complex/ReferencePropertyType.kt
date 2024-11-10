
import com.fasterxml.jackson.annotation.*

/**
 * Represents a reference to a definition type
 */
open class ReferencePropertyType : PropertyType {
    @JsonProperty("target") var target: String? = null
    @JsonProperty("template") var template: HashMap<String, String>? = null
}

