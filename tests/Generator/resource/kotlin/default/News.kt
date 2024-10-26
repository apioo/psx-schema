/**
 * An general news entry
 */
open class News {
    @JsonProperty("config") var config: Meta? = null
    @JsonProperty("inlineConfig") var inlineConfig: Map<String, String>? = null
    @JsonProperty("mapTags") var mapTags: Map<String, String>? = null
    @JsonProperty("mapReceiver") var mapReceiver: Map<String, Author>? = null
    @JsonProperty("tags") var tags: Array<String>? = null
    @JsonProperty("receiver") var receiver: Array<Author>? = null
    @JsonProperty("read") var read: Boolean? = null
    @JsonProperty("author") var author: Author? = null
    @JsonProperty("meta") var meta: Meta? = null
    @JsonProperty("sendDate") var sendDate: java.time.LocalDate? = null
    @JsonProperty("readDate") var readDate: java.time.LocalDateTime? = null
    @JsonProperty("price") var price: Float? = null
    @JsonProperty("rating") var rating: Int? = null
    @JsonProperty("content") var content: String? = null
    @JsonProperty("question") var question: String? = null
    @JsonProperty("version") var version: String? = null
    @JsonProperty("coffeeTime") var coffeeTime: java.time.LocalTime? = null
    @JsonProperty("g-recaptcha-response") var captcha: String? = null
    @JsonProperty("media.fields") var mediaFields: String? = null
    @JsonProperty("payload") var payload: Any? = null
}

