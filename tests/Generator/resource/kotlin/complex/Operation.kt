
import com.fasterxml.jackson.annotation.*

open class Operation {
    @JsonProperty("method") var method: String? = null
    @JsonProperty("path") var path: String? = null
    @JsonProperty("return") var return: Response? = null
    @JsonProperty("arguments") var arguments: HashMap<String, Argument>? = null
    @JsonProperty("throws") var throws: ArrayList<Response>? = null
    @JsonProperty("description") var description: String? = null
    @JsonProperty("stability") var stability: Int? = null
    @JsonProperty("security") var security: ArrayList<String>? = null
    @JsonProperty("authorization") var authorization: Boolean? = null
    @JsonProperty("tags") var tags: ArrayList<String>? = null
}

