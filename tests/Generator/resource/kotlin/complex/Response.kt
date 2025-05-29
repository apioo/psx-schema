
import com.fasterxml.jackson.annotation.*

/**
 * Describes the response of the operation
 */
open class Response {
    @JsonProperty("code") var code: Int? = null
    @JsonProperty("contentType") var contentType: String? = null
    @JsonProperty("schema") var schema: PropertyType? = null
}

