package Foo.Bar;


import com.fasterxml.jackson.annotation.*

open class Import {
    @JsonProperty("students") var students: My.Import.StudentMap? = null
    @JsonProperty("student") var student: My.Import.Student? = null
}

