
import com.fasterxml.jackson.annotation.*
/**
 * Base definition type
 */
open abstract class DefinitionType {
    @JsonProperty("description") var description: String? = null
    @JsonProperty("type") var type: String? = null
    @JsonProperty("deprecated") var deprecated: Boolean? = null
}

