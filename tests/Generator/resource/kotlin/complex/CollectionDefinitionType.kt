/**
 * Base type for the map and array collection type
 */
open abstract class CollectionDefinitionType : DefinitionType {
    @JsonProperty("type") var type: String? = null
    @JsonProperty("schema") var schema: PropertyType? = null
}

