
import com.fasterxml.jackson.annotation.*

/**
 * Base property type
 */
open abstract class PropertyType {
    @JsonProperty("deprecated") var deprecated: Boolean? = null
    @JsonProperty("description") var description: String? = null
    @JsonProperty("nullable") var nullable: Boolean? = null
    @JsonProperty("type") var type: String? = null
}

