/**
 * The TypeAPI Root
 */
open class TypeAPI : TypeSchema {
    @JsonProperty("baseUrl") var baseUrl: String? = null
    @JsonProperty("security") var security: Security? = null
    @JsonProperty("operations") var operations: Map<String, Operation>? = null
}

