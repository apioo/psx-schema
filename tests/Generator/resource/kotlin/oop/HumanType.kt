
import com.fasterxml.jackson.annotation.*

open class HumanType {
    @JsonProperty("firstName") var firstName: String? = null
    @JsonProperty("parent") var parent: HumanType? = null
}

