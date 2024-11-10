
import com.fasterxml.jackson.annotation.*
/**
 * TypeSchema specification
 */
open class TypeSchema {
    @JsonProperty("import") var import: HashMap<String, String>? = null
    @JsonProperty("definitions") var definitions: HashMap<String, DefinitionType>? = null
    @JsonProperty("root") var root: String? = null
}

