
import com.fasterxml.jackson.annotation.*;

@JsonClassDescription("An general news entry")
public class News {
    private Meta config;
    private java.util.Map<String, String> inlineConfig;
    private java.util.Map<String, String> mapTags;
    private java.util.Map<String, Author> mapReceiver;
    private java.util.List<String> tags;
    private java.util.List<Author> receiver;
    private java.util.List<java.util.List<Double>> data;
    private Boolean read;
    @NotNull
    private Author author;
    private Meta meta;
    private java.time.LocalDate sendDate;
    private java.time.LocalDateTime readDate;
    private Double price;
    private Integer rating;
    @JsonPropertyDescription("Contains the \"main\" content of the news entry")
    @NotNull
    private String content;
    private String question;
    private String version;
    private java.time.LocalTime coffeeTime;
    private String captcha;
    private String mediaFields;
    private Object payload;

    @JsonSetter("config")
    public void setConfig(Meta config) {
        this.config = config;
    }

    @JsonGetter("config")
    public Meta getConfig() {
        return this.config;
    }

    @JsonSetter("inlineConfig")
    public void setInlineConfig(java.util.Map<String, String> inlineConfig) {
        this.inlineConfig = inlineConfig;
    }

    @JsonGetter("inlineConfig")
    public java.util.Map<String, String> getInlineConfig() {
        return this.inlineConfig;
    }

    @JsonSetter("mapTags")
    public void setMapTags(java.util.Map<String, String> mapTags) {
        this.mapTags = mapTags;
    }

    @JsonGetter("mapTags")
    public java.util.Map<String, String> getMapTags() {
        return this.mapTags;
    }

    @JsonSetter("mapReceiver")
    public void setMapReceiver(java.util.Map<String, Author> mapReceiver) {
        this.mapReceiver = mapReceiver;
    }

    @JsonGetter("mapReceiver")
    public java.util.Map<String, Author> getMapReceiver() {
        return this.mapReceiver;
    }

    @JsonSetter("tags")
    public void setTags(java.util.List<String> tags) {
        this.tags = tags;
    }

    @JsonGetter("tags")
    public java.util.List<String> getTags() {
        return this.tags;
    }

    @JsonSetter("receiver")
    public void setReceiver(java.util.List<Author> receiver) {
        this.receiver = receiver;
    }

    @JsonGetter("receiver")
    public java.util.List<Author> getReceiver() {
        return this.receiver;
    }

    @JsonSetter("data")
    public void setData(java.util.List<java.util.List<Double>> data) {
        this.data = data;
    }

    @JsonGetter("data")
    public java.util.List<java.util.List<Double>> getData() {
        return this.data;
    }

    @JsonSetter("read")
    public void setRead(Boolean read) {
        this.read = read;
    }

    @JsonGetter("read")
    public Boolean getRead() {
        return this.read;
    }

    @JsonSetter("author")
    public void setAuthor(@NotNull Author author) {
        this.author = author;
    }

    @JsonGetter("author")
    @NotNull
    public Author getAuthor() {
        return this.author;
    }

    @JsonSetter("meta")
    public void setMeta(Meta meta) {
        this.meta = meta;
    }

    @JsonGetter("meta")
    public Meta getMeta() {
        return this.meta;
    }

    @JsonSetter("sendDate")
    public void setSendDate(java.time.LocalDate sendDate) {
        this.sendDate = sendDate;
    }

    @JsonGetter("sendDate")
    public java.time.LocalDate getSendDate() {
        return this.sendDate;
    }

    @JsonSetter("readDate")
    public void setReadDate(java.time.LocalDateTime readDate) {
        this.readDate = readDate;
    }

    @JsonGetter("readDate")
    public java.time.LocalDateTime getReadDate() {
        return this.readDate;
    }

    @JsonSetter("price")
    public void setPrice(Double price) {
        this.price = price;
    }

    @JsonGetter("price")
    public Double getPrice() {
        return this.price;
    }

    @JsonSetter("rating")
    public void setRating(Integer rating) {
        this.rating = rating;
    }

    @JsonGetter("rating")
    public Integer getRating() {
        return this.rating;
    }

    @JsonSetter("content")
    public void setContent(@NotNull String content) {
        this.content = content;
    }

    @JsonGetter("content")
    @NotNull
    public String getContent() {
        return this.content;
    }

    @JsonSetter("question")
    public void setQuestion(String question) {
        this.question = question;
    }

    @JsonGetter("question")
    public String getQuestion() {
        return this.question;
    }

    @JsonSetter("version")
    public void setVersion(String version) {
        this.version = version;
    }

    @JsonGetter("version")
    public String getVersion() {
        return this.version;
    }

    @JsonSetter("coffeeTime")
    public void setCoffeeTime(java.time.LocalTime coffeeTime) {
        this.coffeeTime = coffeeTime;
    }

    @JsonGetter("coffeeTime")
    public java.time.LocalTime getCoffeeTime() {
        return this.coffeeTime;
    }

    @JsonSetter("g-recaptcha-response")
    public void setCaptcha(String captcha) {
        this.captcha = captcha;
    }

    @JsonGetter("g-recaptcha-response")
    public String getCaptcha() {
        return this.captcha;
    }

    @JsonSetter("media.fields")
    public void setMediaFields(String mediaFields) {
        this.mediaFields = mediaFields;
    }

    @JsonGetter("media.fields")
    public String getMediaFields() {
        return this.mediaFields;
    }

    @JsonSetter("payload")
    public void setPayload(Object payload) {
        this.payload = payload;
    }

    @JsonGetter("payload")
    public Object getPayload() {
        return this.payload;
    }
}

