open class Response {
    @JsonProperty("code") var code: Int? = null
    @JsonProperty("contentType") var contentType: String? = null
    @JsonProperty("schema") var schema: PropertyType? = null
}

