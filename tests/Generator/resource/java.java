import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * Location of the person
 */
public class Location {
    private float lat;
    private float _long;
    @JsonProperty("lat")
    public void setLat(float lat) {
        this.lat = lat;
    }
    @JsonProperty("lat")
    public float getLat() {
        return this.lat;
    }
    @JsonProperty("long")
    public void setLong(float _long) {
        this._long = _long;
    }
    @JsonProperty("long")
    public float getLong() {
        return this._long;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("lat", this.lat);
        map.put("long", this._long);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * An application
 */
public class Web {
    private String name;
    private String url;
    @JsonProperty("name")
    public void setName(String name) {
        this.name = name;
    }
    @JsonProperty("name")
    public String getName() {
        return this.name;
    }
    @JsonProperty("url")
    public void setUrl(String url) {
        this.url = url;
    }
    @JsonProperty("url")
    public String getUrl() {
        return this.url;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("name", this.name);
        map.put("url", this.url);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * An simple author element with some description
 */
public class Author {
    private String title;
    private String email;
    private String[] categories;
    private Location[] locations;
    private Location origin;
    @JsonProperty("title")
    public void setTitle(String title) {
        this.title = title;
    }
    @JsonProperty("title")
    public String getTitle() {
        return this.title;
    }
    @JsonProperty("email")
    public void setEmail(String email) {
        this.email = email;
    }
    @JsonProperty("email")
    public String getEmail() {
        return this.email;
    }
    @JsonProperty("categories")
    public void setCategories(String[] categories) {
        this.categories = categories;
    }
    @JsonProperty("categories")
    public String[] getCategories() {
        return this.categories;
    }
    @JsonProperty("locations")
    public void setLocations(Location[] locations) {
        this.locations = locations;
    }
    @JsonProperty("locations")
    public Location[] getLocations() {
        return this.locations;
    }
    @JsonProperty("origin")
    public void setOrigin(Location origin) {
        this.origin = origin;
    }
    @JsonProperty("origin")
    public Location getOrigin() {
        return this.origin;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("title", this.title);
        map.put("email", this.email);
        map.put("categories", this.categories);
        map.put("locations", this.locations);
        map.put("origin", this.origin);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;
import java.util.HashMap;
public class Meta extends HashMap<String, String> {
}

import com.fasterxml.jackson.annotation.JsonProperty;
import java.net.URI;
import java.time.Duration;
import java.time.LocalDate;
import java.time.LocalTime;
import java.time.LocalDateTime;
import java.util.HashMap;

/**
 * An general news entry
 */
public class News {
    private Meta config;
    private HashMap<String, String> inlineConfig;
    private String[] tags;
    private Author[] receiver;
    private Object[] resources;
    private byte[] profileImage;
    private boolean read;
    private Object source;
    private Author author;
    private Meta meta;
    private LocalDate sendDate;
    private LocalDateTime readDate;
    private Duration expires;
    private float price;
    private int rating;
    private String content;
    private String question;
    private String version;
    private LocalTime coffeeTime;
    private URI profileUri;
    private String captcha;
    private Object payload;
    @JsonProperty("config")
    public void setConfig(Meta config) {
        this.config = config;
    }
    @JsonProperty("config")
    public Meta getConfig() {
        return this.config;
    }
    @JsonProperty("inlineConfig")
    public void setInlineConfig(HashMap<String, String> inlineConfig) {
        this.inlineConfig = inlineConfig;
    }
    @JsonProperty("inlineConfig")
    public HashMap<String, String> getInlineConfig() {
        return this.inlineConfig;
    }
    @JsonProperty("tags")
    public void setTags(String[] tags) {
        this.tags = tags;
    }
    @JsonProperty("tags")
    public String[] getTags() {
        return this.tags;
    }
    @JsonProperty("receiver")
    public void setReceiver(Author[] receiver) {
        this.receiver = receiver;
    }
    @JsonProperty("receiver")
    public Author[] getReceiver() {
        return this.receiver;
    }
    @JsonProperty("resources")
    public void setResources(Object[] resources) {
        this.resources = resources;
    }
    @JsonProperty("resources")
    public Object[] getResources() {
        return this.resources;
    }
    @JsonProperty("profileImage")
    public void setProfileImage(byte[] profileImage) {
        this.profileImage = profileImage;
    }
    @JsonProperty("profileImage")
    public byte[] getProfileImage() {
        return this.profileImage;
    }
    @JsonProperty("read")
    public void setRead(boolean read) {
        this.read = read;
    }
    @JsonProperty("read")
    public boolean getRead() {
        return this.read;
    }
    @JsonProperty("source")
    public void setSource(Object source) {
        this.source = source;
    }
    @JsonProperty("source")
    public Object getSource() {
        return this.source;
    }
    @JsonProperty("author")
    public void setAuthor(Author author) {
        this.author = author;
    }
    @JsonProperty("author")
    public Author getAuthor() {
        return this.author;
    }
    @JsonProperty("meta")
    public void setMeta(Meta meta) {
        this.meta = meta;
    }
    @JsonProperty("meta")
    public Meta getMeta() {
        return this.meta;
    }
    @JsonProperty("sendDate")
    public void setSendDate(LocalDate sendDate) {
        this.sendDate = sendDate;
    }
    @JsonProperty("sendDate")
    public LocalDate getSendDate() {
        return this.sendDate;
    }
    @JsonProperty("readDate")
    public void setReadDate(LocalDateTime readDate) {
        this.readDate = readDate;
    }
    @JsonProperty("readDate")
    public LocalDateTime getReadDate() {
        return this.readDate;
    }
    @JsonProperty("expires")
    public void setExpires(Duration expires) {
        this.expires = expires;
    }
    @JsonProperty("expires")
    public Duration getExpires() {
        return this.expires;
    }
    @JsonProperty("price")
    public void setPrice(float price) {
        this.price = price;
    }
    @JsonProperty("price")
    public float getPrice() {
        return this.price;
    }
    @JsonProperty("rating")
    public void setRating(int rating) {
        this.rating = rating;
    }
    @JsonProperty("rating")
    public int getRating() {
        return this.rating;
    }
    @JsonProperty("content")
    public void setContent(String content) {
        this.content = content;
    }
    @JsonProperty("content")
    public String getContent() {
        return this.content;
    }
    @JsonProperty("question")
    public void setQuestion(String question) {
        this.question = question;
    }
    @JsonProperty("question")
    public String getQuestion() {
        return this.question;
    }
    @JsonProperty("version")
    public void setVersion(String version) {
        this.version = version;
    }
    @JsonProperty("version")
    public String getVersion() {
        return this.version;
    }
    @JsonProperty("coffeeTime")
    public void setCoffeeTime(LocalTime coffeeTime) {
        this.coffeeTime = coffeeTime;
    }
    @JsonProperty("coffeeTime")
    public LocalTime getCoffeeTime() {
        return this.coffeeTime;
    }
    @JsonProperty("profileUri")
    public void setProfileUri(URI profileUri) {
        this.profileUri = profileUri;
    }
    @JsonProperty("profileUri")
    public URI getProfileUri() {
        return this.profileUri;
    }
    @JsonProperty("g-recaptcha-response")
    public void setCaptcha(String captcha) {
        this.captcha = captcha;
    }
    @JsonProperty("g-recaptcha-response")
    public String getCaptcha() {
        return this.captcha;
    }
    @JsonProperty("payload")
    public void setPayload(Object payload) {
        this.payload = payload;
    }
    @JsonProperty("payload")
    public Object getPayload() {
        return this.payload;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("config", this.config);
        map.put("inlineConfig", this.inlineConfig);
        map.put("tags", this.tags);
        map.put("receiver", this.receiver);
        map.put("resources", this.resources);
        map.put("profileImage", this.profileImage);
        map.put("read", this.read);
        map.put("source", this.source);
        map.put("author", this.author);
        map.put("meta", this.meta);
        map.put("sendDate", this.sendDate);
        map.put("readDate", this.readDate);
        map.put("expires", this.expires);
        map.put("price", this.price);
        map.put("rating", this.rating);
        map.put("content", this.content);
        map.put("question", this.question);
        map.put("version", this.version);
        map.put("coffeeTime", this.coffeeTime);
        map.put("profileUri", this.profileUri);
        map.put("g-recaptcha-response", this.captcha);
        map.put("payload", this.payload);
        return map;
    }
}
