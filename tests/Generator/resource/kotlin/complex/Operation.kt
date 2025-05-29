
import com.fasterxml.jackson.annotation.*

open class Operation {
    @JsonProperty("arguments") var arguments: HashMap<String, Argument>? = null
    @JsonProperty("authorization") var authorization: Boolean? = null
    @JsonProperty("description") var description: String? = null
    @JsonProperty("method") var method: String? = null
    @JsonProperty("path") var path: String? = null
    @JsonProperty("return") var return: Response? = null
    @JsonProperty("security") var security: ArrayList<String>? = null
    @JsonProperty("stability") var stability: Int? = null
    @JsonProperty("throws") var throws: ArrayList<Response>? = null
}

