
import com.fasterxml.jackson.annotation.*

open class SecurityApiKey : Security {
    @JsonProperty("in") var in: String? = null
    @JsonProperty("name") var name: String? = null
}

