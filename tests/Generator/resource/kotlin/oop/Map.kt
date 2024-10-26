open class Map<P, T> {
    @JsonProperty("totalResults") var totalResults: Int? = null
    @JsonProperty("parent") var parent: P? = null
    @JsonProperty("entries") var entries: Array<T>? = null
}

