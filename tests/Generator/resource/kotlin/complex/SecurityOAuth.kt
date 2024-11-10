
import com.fasterxml.jackson.annotation.*

open class SecurityOAuth : Security {
    @JsonProperty("tokenUrl") var tokenUrl: String? = null
    @JsonProperty("authorizationUrl") var authorizationUrl: String? = null
    @JsonProperty("scopes") var scopes: ArrayList<String>? = null
}

