
import com.fasterxml.jackson.annotation.*

/**
 * An simple author element with some description
 */
open class Author {
    @JsonProperty("title") var title: String
    @JsonProperty("email") var email: String? = null
    @JsonProperty("categories") var categories: ArrayList<String>? = null
    @JsonProperty("locations") var locations: ArrayList<Location>? = null
    @JsonProperty("origin") var origin: Location? = null
}

