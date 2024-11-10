
import com.fasterxml.jackson.annotation.*

open class SecurityApiKey : Security {
    @JsonProperty("name") var name: String? = null
    @JsonProperty("in") var in: String? = null
}

