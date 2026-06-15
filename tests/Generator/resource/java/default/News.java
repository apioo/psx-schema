
import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("An general news entry")
public class News {
    @JsonProperty("config")
    private Meta config;

    @JsonProperty("inlineConfig")
    private java.util.Map<String, String> inlineConfig;

    @JsonProperty("mapTags")
    private java.util.Map<String, String> mapTags;

    @JsonProperty("mapReceiver")
    private java.util.Map<String, Author> mapReceiver;

    @JsonProperty("tags")
    private java.util.List<String> tags;

    @JsonProperty("receiver")
    private java.util.List<Author> receiver;

    @JsonProperty("data")
    private java.util.List<java.util.List<Double>> data;

    @JsonProperty("read")
    private Boolean read;

    @JsonProperty("author")
    private Author author;

    @JsonProperty("meta")
    private Meta meta;

    @JsonProperty("sendDate")
    private java.time.LocalDate sendDate;

    @JsonProperty("readDate")
    private java.time.LocalDateTime readDate;

    @JsonProperty("price")
    private Double price;

    @JsonProperty("rating")
    private Integer rating;

    @JsonPropertyDescription("Contains the \"main\" content of the news entry")
    @JsonProperty("content")
    private String content;

    @JsonProperty("question")
    private String question;

    @JsonProperty("version")
    private String version = "1.0";

    @JsonProperty("coffeeTime")
    private java.time.LocalTime coffeeTime;

    @JsonProperty("g-recaptcha-response")
    private String captcha;

    @JsonProperty("media.fields")
    private String mediaFields;

    @JsonProperty("payload")
    private Object payload;


    public void setConfig(Meta config) {
        this.config = config;
    }

    public Meta getConfig() {
        return this.config;
    }

    public void setInlineConfig(java.util.Map<String, String> inlineConfig) {
        this.inlineConfig = inlineConfig;
    }

    public java.util.Map<String, String> getInlineConfig() {
        return this.inlineConfig;
    }

    public void setMapTags(java.util.Map<String, String> mapTags) {
        this.mapTags = mapTags;
    }

    public java.util.Map<String, String> getMapTags() {
        return this.mapTags;
    }

    public void setMapReceiver(java.util.Map<String, Author> mapReceiver) {
        this.mapReceiver = mapReceiver;
    }

    public java.util.Map<String, Author> getMapReceiver() {
        return this.mapReceiver;
    }

    public void setTags(java.util.List<String> tags) {
        this.tags = tags;
    }

    public java.util.List<String> getTags() {
        return this.tags;
    }

    public void setReceiver(java.util.List<Author> receiver) {
        this.receiver = receiver;
    }

    public java.util.List<Author> getReceiver() {
        return this.receiver;
    }

    public void setData(java.util.List<java.util.List<Double>> data) {
        this.data = data;
    }

    public java.util.List<java.util.List<Double>> getData() {
        return this.data;
    }

    public void setRead(Boolean read) {
        this.read = read;
    }

    public Boolean getRead() {
        return this.read;
    }

    public void setAuthor(Author author) {
        this.author = author;
    }

    public Author getAuthor() {
        return this.author;
    }

    public void setMeta(Meta meta) {
        this.meta = meta;
    }

    public Meta getMeta() {
        return this.meta;
    }

    public void setSendDate(java.time.LocalDate sendDate) {
        this.sendDate = sendDate;
    }

    public java.time.LocalDate getSendDate() {
        return this.sendDate;
    }

    public void setReadDate(java.time.LocalDateTime readDate) {
        this.readDate = readDate;
    }

    public java.time.LocalDateTime getReadDate() {
        return this.readDate;
    }

    @Deprecated
    public void setPrice(Double price) {
        this.price = price;
    }

    @Deprecated
    public Double getPrice() {
        return this.price;
    }

    public void setRating(Integer rating) {
        this.rating = rating;
    }

    public Integer getRating() {
        return this.rating;
    }

    public void setContent(String content) {
        this.content = content;
    }

    public String getContent() {
        return this.content;
    }

    public void setQuestion(String question) {
        this.question = question;
    }

    public String getQuestion() {
        return this.question;
    }

    public void setVersion(String version) {
        this.version = version;
    }

    public String getVersion() {
        return this.version;
    }

    public void setCoffeeTime(java.time.LocalTime coffeeTime) {
        this.coffeeTime = coffeeTime;
    }

    public java.time.LocalTime getCoffeeTime() {
        return this.coffeeTime;
    }

    public void setCaptcha(String captcha) {
        this.captcha = captcha;
    }

    public String getCaptcha() {
        return this.captcha;
    }

    public void setMediaFields(String mediaFields) {
        this.mediaFields = mediaFields;
    }

    public String getMediaFields() {
        return this.mediaFields;
    }

    public void setPayload(Object payload) {
        this.payload = payload;
    }

    public Object getPayload() {
        return this.payload;
    }
}

