
import com.fasterxml.jackson.annotation.*

/**
 * A struct represents a class/structure with a fix set of defined properties.
 */
open class StructDefinitionType : DefinitionType {
    @JsonProperty("base") var base: Boolean? = null
    @JsonProperty("discriminator") var discriminator: String? = null
    @JsonProperty("mapping") var mapping: HashMap<String, String>? = null
    @JsonProperty("parent") var parent: ReferencePropertyType? = null
    @JsonProperty("properties") var properties: HashMap<String, PropertyType>? = null
}

