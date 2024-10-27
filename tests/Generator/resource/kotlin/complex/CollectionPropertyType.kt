/**
 * Base collection property type
 */
open abstract class CollectionPropertyType : PropertyType {
    @JsonProperty("schema") var schema: PropertyType? = null
}

