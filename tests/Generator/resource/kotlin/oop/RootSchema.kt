
import com.fasterxml.jackson.annotation.*

open class RootSchema {
    @JsonProperty("students") var students: StudentMap? = null
}

