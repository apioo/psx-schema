/**
 * Base collection type
 */
open abstract class CollectionDefinitionType : DefinitionType {
    @JsonProperty("schema") var schema: PropertyType? = null
}

