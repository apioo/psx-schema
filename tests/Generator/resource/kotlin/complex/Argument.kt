
import com.fasterxml.jackson.annotation.*

/**
 * Describes arguments of the operation
 */
open class Argument {
    @JsonProperty("contentType") var contentType: String? = null
    @JsonProperty("in") var in: String? = null
    @JsonProperty("name") var name: String? = null
    @JsonProperty("schema") var schema: PropertyType? = null
}

