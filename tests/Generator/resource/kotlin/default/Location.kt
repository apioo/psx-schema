
import com.fasterxml.jackson.annotation.*

/**
 * Location of the person
 */
open class Location {
    @JsonProperty("lat")
    var lat: Float? = null
    @JsonProperty("long")
    var long: Float? = null
}

