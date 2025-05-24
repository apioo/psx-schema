
import com.fasterxml.jackson.annotation.*

/**
 * An general news entry
 */
open class News {
    @JsonProperty("config") var config: Meta? = null
    @JsonProperty("inlineConfig") var inlineConfig: HashMap<String, String>? = null
    @JsonProperty("mapTags") var mapTags: HashMap<String, String>? = null
    @JsonProperty("mapReceiver") var mapReceiver: HashMap<String, Author>? = null
    @JsonProperty("tags") var tags: ArrayList<String>? = null
    @JsonProperty("receiver") var receiver: ArrayList<Author>? = null
    @JsonProperty("data") var data: ArrayList<ArrayList<Float>>? = null
    @JsonProperty("read") var read: Boolean? = null
    @JsonProperty("author") var author: Author
    @JsonProperty("meta") var meta: Meta? = null
    @JsonProperty("sendDate") var sendDate: java.time.LocalDate? = null
    @JsonProperty("readDate") var readDate: java.time.LocalDateTime? = null
    @JsonProperty("price") var price: Float? = null
    @JsonProperty("rating") var rating: Int? = null
    @JsonProperty("content") var content: String
    @JsonProperty("question") var question: String? = null
    @JsonProperty("version") var version: String? = null
    @JsonProperty("coffeeTime") var coffeeTime: java.time.LocalTime? = null
    @JsonProperty("g-recaptcha-response") var captcha: String? = null
    @JsonProperty("media.fields") var mediaFields: String? = null
    @JsonProperty("payload") var payload: Any? = null
}

