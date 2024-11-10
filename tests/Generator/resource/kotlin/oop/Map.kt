
import com.fasterxml.jackson.annotation.*

open class Map<P, T> {
    @JsonProperty("totalResults") var totalResults: Int? = null
    @JsonProperty("parent") var parent: P? = null
    @JsonProperty("entries") var entries: ArrayList<T>? = null
}

