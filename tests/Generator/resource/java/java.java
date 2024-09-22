import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Location of the person
 */
public class Location {
    private Double lat;
    private Double _long;
    @JsonSetter("lat")
    public void setLat(Double lat) {
        this.lat = lat;
    }
    @JsonGetter("lat")
    public Double getLat() {
        return this.lat;
    }
    @JsonSetter("long")
    public void setLong(Double _long) {
        this._long = _long;
    }
    @JsonGetter("long")
    public Double getLong() {
        return this._long;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * An application
 */
public class Web {
    private String name;
    private String url;
    @JsonSetter("name")
    public void setName(String name) {
        this.name = name;
    }
    @JsonGetter("name")
    public String getName() {
        return this.name;
    }
    @JsonSetter("url")
    public void setUrl(String url) {
        this.url = url;
    }
    @JsonGetter("url")
    public String getUrl() {
        return this.url;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * An simple author element with some description
 */
public class Author {
    private String title;
    private String email;
    private java.util.List<String> categories;
    private java.util.List<Location> locations;
    private Location origin;
    @JsonSetter("title")
    public void setTitle(String title) {
        this.title = title;
    }
    @JsonGetter("title")
    public String getTitle() {
        return this.title;
    }
    @JsonSetter("email")
    public void setEmail(String email) {
        this.email = email;
    }
    @JsonGetter("email")
    public String getEmail() {
        return this.email;
    }
    @JsonSetter("categories")
    public void setCategories(java.util.List<String> categories) {
        this.categories = categories;
    }
    @JsonGetter("categories")
    public java.util.List<String> getCategories() {
        return this.categories;
    }
    @JsonSetter("locations")
    public void setLocations(java.util.List<Location> locations) {
        this.locations = locations;
    }
    @JsonGetter("locations")
    public java.util.List<Location> getLocations() {
        return this.locations;
    }
    @JsonSetter("origin")
    public void setOrigin(Location origin) {
        this.origin = origin;
    }
    @JsonGetter("origin")
    public Location getOrigin() {
        return this.origin;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class Meta extends java.util.HashMap<String, String> {
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * An general news entry
 */
public class News {
    private Meta config;
    private java.util.Map<String, String> inlineConfig;
    private java.util.Map<String, String> mapTags;
    private java.util.Map<String, Author> mapReceiver;
    private java.util.Map<String, Object> mapResources;
    private java.util.List<String> tags;
    private java.util.List<Author> receiver;
    private java.util.List<Object> resources;
    private String profileImage;
    private Boolean read;
    private Object source;
    private Author author;
    private Meta meta;
    private java.time.LocalDate sendDate;
    private java.time.LocalDateTime readDate;
    private String expires;
    private String range;
    private Double price;
    private Integer rating;
    private String content;
    private String question;
    private String version;
    private java.time.LocalTime coffeeTime;
    private String profileUri;
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
    @JsonSetter("mapResources")
    public void setMapResources(java.util.Map<String, Object> mapResources) {
        this.mapResources = mapResources;
    }
    @JsonGetter("mapResources")
    public java.util.Map<String, Object> getMapResources() {
        return this.mapResources;
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
    @JsonSetter("resources")
    public void setResources(java.util.List<Object> resources) {
        this.resources = resources;
    }
    @JsonGetter("resources")
    public java.util.List<Object> getResources() {
        return this.resources;
    }
    @JsonSetter("profileImage")
    public void setProfileImage(String profileImage) {
        this.profileImage = profileImage;
    }
    @JsonGetter("profileImage")
    public String getProfileImage() {
        return this.profileImage;
    }
    @JsonSetter("read")
    public void setRead(Boolean read) {
        this.read = read;
    }
    @JsonGetter("read")
    public Boolean getRead() {
        return this.read;
    }
    @JsonSetter("source")
    public void setSource(Object source) {
        this.source = source;
    }
    @JsonGetter("source")
    public Object getSource() {
        return this.source;
    }
    @JsonSetter("author")
    public void setAuthor(Author author) {
        this.author = author;
    }
    @JsonGetter("author")
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
    @JsonSetter("expires")
    public void setExpires(String expires) {
        this.expires = expires;
    }
    @JsonGetter("expires")
    public String getExpires() {
        return this.expires;
    }
    @JsonSetter("range")
    public void setRange(String range) {
        this.range = range;
    }
    @JsonGetter("range")
    public String getRange() {
        return this.range;
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
    public void setContent(String content) {
        this.content = content;
    }
    @JsonGetter("content")
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
    @JsonSetter("profileUri")
    public void setProfileUri(String profileUri) {
        this.profileUri = profileUri;
    }
    @JsonGetter("profileUri")
    public String getProfileUri() {
        return this.profileUri;
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
