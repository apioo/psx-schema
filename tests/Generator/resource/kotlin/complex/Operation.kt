open class Operation {
    @JsonProperty("method") var method: String? = null
    @JsonProperty("path") var path: String? = null
    @JsonProperty("return") var return: Response? = null
    @JsonProperty("arguments") var arguments: Map<String, Argument>? = null
    @JsonProperty("throws") var throws: Array<Response>? = null
    @JsonProperty("description") var description: String? = null
    @JsonProperty("stability") var stability: Int? = null
    @JsonProperty("security") var security: Array<String>? = null
    @JsonProperty("authorization") var authorization: Boolean? = null
    @JsonProperty("tags") var tags: Array<String>? = null
}

