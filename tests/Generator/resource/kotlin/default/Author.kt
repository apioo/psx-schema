/**
 * An simple author element with some description
 */
open class Author {
    @JsonProperty("title") var title: String? = null
    @JsonProperty("email") var email: String? = null
    @JsonProperty("categories") var categories: Array<String>? = null
    @JsonProperty("locations") var locations: Array<Location>? = null
    @JsonProperty("origin") var origin: Location? = null
}

