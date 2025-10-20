
import com.fasterxml.jackson.annotation.*

open class SecurityOAuth : Security {
    @JsonProperty("authorizationUrl")
    var authorizationUrl: String? = null
    @JsonProperty("scopes")
    var scopes: ArrayList<String>? = null
    @JsonProperty("tokenUrl")
    var tokenUrl: String? = null
}

