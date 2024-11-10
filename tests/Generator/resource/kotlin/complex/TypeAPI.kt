
import com.fasterxml.jackson.annotation.*

/**
 * The TypeAPI Root
 */
open class TypeAPI : TypeSchema {
    @JsonProperty("baseUrl") var baseUrl: String? = null
    @JsonProperty("security") var security: Security? = null
    @JsonProperty("operations") var operations: HashMap<String, Operation>? = null
}

