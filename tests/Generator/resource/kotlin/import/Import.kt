
import com.fasterxml.jackson.annotation.*

open class Import {
    @JsonProperty("students")
    var students: StudentMap? = null
    @JsonProperty("student")
    var student: Student? = null
}

