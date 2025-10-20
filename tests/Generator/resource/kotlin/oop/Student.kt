
import com.fasterxml.jackson.annotation.*

open class Student : HumanType {
    @JsonProperty("matricleNumber")
    var matricleNumber: String? = null
}

