/**
 * Base property type
 */
open abstract class PropertyType {
    @JsonProperty("description") var description: String? = null
    @JsonProperty("type") var type: String? = null
    @JsonProperty("deprecated") var deprecated: Boolean? = null
    @JsonProperty("nullable") var nullable: Boolean? = null
}

