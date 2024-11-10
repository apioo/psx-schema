
import com.fasterxml.jackson.annotation.*

open class Argument {
    @JsonProperty("in") var in: String? = null
    @JsonProperty("schema") var schema: PropertyType? = null
    @JsonProperty("contentType") var contentType: String? = null
    @JsonProperty("name") var name: String? = null
}

