/**
 * Base collection property type
 */
open abstract class CollectionPropertyType : PropertyType {
    @JsonProperty("type") var type: String? = null
    @JsonProperty("schema") var schema: PropertyType? = null
}

