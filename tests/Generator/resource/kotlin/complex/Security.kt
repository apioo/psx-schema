
import com.fasterxml.jackson.annotation.*

open abstract class Security {
    @JsonProperty("type") var type: String? = null
}

