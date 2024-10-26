/**
 * Represents a map which contains a dynamic set of key value entries
 */
open class MapPropertyType : CollectionPropertyType {
    @JsonProperty("type") var type: String? = null
}

