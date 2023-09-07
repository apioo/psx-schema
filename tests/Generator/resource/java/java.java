import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;

/**
 * Location of the person
 */
public class Location {
    private double lat;
    private double _long;
    @JsonSetter("lat")
    public void setLat(double lat) {
        this.lat = lat;
    }
    @JsonGetter("lat")
    public double getLat() {
        return this.lat;
    }
    @JsonSetter("long")
    public void setLong(double _long) {
        this._long = _long;
    }
    @JsonGetter("long")
    public double getLong() {
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
    private String[] categories;
    private Location[] locations;
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
    public void setCategories(String[] categories) {
        this.categories = categories;
    }
    @JsonGetter("categories")
    public String[] getCategories() {
        return this.categories;
    }
    @JsonSetter("locations")
    public void setLocations(Location[] locations) {
        this.locations = locations;
    }
    @JsonGetter("locations")
    public Location[] getLocations() {
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
import java.util.HashMap;
public class Meta extends HashMap<String, String> {
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.net.URI;
import java.time.Duration;
import java.time.Period;
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
    private HashMap<String, String> mapTags;
    private HashMap<String, Author> mapReceiver;
    private HashMap<String, Object> mapResources;
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
    private Period expires;
    private Duration range;
    private double price;
    private int rating;
    private String content;
    private String question;
    private String version;
    private LocalTime coffeeTime;
    private URI profileUri;
    private String captcha;
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
    public void setInlineConfig(HashMap<String, String> inlineConfig) {
        this.inlineConfig = inlineConfig;
    }
    @JsonGetter("inlineConfig")
    public HashMap<String, String> getInlineConfig() {
        return this.inlineConfig;
    }
    @JsonSetter("mapTags")
    public void setMapTags(HashMap<String, String> mapTags) {
        this.mapTags = mapTags;
    }
    @JsonGetter("mapTags")
    public HashMap<String, String> getMapTags() {
        return this.mapTags;
    }
    @JsonSetter("mapReceiver")
    public void setMapReceiver(HashMap<String, Author> mapReceiver) {
        this.mapReceiver = mapReceiver;
    }
    @JsonGetter("mapReceiver")
    public HashMap<String, Author> getMapReceiver() {
        return this.mapReceiver;
    }
    @JsonSetter("mapResources")
    public void setMapResources(HashMap<String, Object> mapResources) {
        this.mapResources = mapResources;
    }
    @JsonGetter("mapResources")
    public HashMap<String, Object> getMapResources() {
        return this.mapResources;
    }
    @JsonSetter("tags")
    public void setTags(String[] tags) {
        this.tags = tags;
    }
    @JsonGetter("tags")
    public String[] getTags() {
        return this.tags;
    }
    @JsonSetter("receiver")
    public void setReceiver(Author[] receiver) {
        this.receiver = receiver;
    }
    @JsonGetter("receiver")
    public Author[] getReceiver() {
        return this.receiver;
    }
    @JsonSetter("resources")
    public void setResources(Object[] resources) {
        this.resources = resources;
    }
    @JsonGetter("resources")
    public Object[] getResources() {
        return this.resources;
    }
    @JsonSetter("profileImage")
    public void setProfileImage(byte[] profileImage) {
        this.profileImage = profileImage;
    }
    @JsonGetter("profileImage")
    public byte[] getProfileImage() {
        return this.profileImage;
    }
    @JsonSetter("read")
    public void setRead(boolean read) {
        this.read = read;
    }
    @JsonGetter("read")
    public boolean getRead() {
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
    public void setSendDate(LocalDate sendDate) {
        this.sendDate = sendDate;
    }
    @JsonGetter("sendDate")
    public LocalDate getSendDate() {
        return this.sendDate;
    }
    @JsonSetter("readDate")
    public void setReadDate(LocalDateTime readDate) {
        this.readDate = readDate;
    }
    @JsonGetter("readDate")
    public LocalDateTime getReadDate() {
        return this.readDate;
    }
    @JsonSetter("expires")
    public void setExpires(Period expires) {
        this.expires = expires;
    }
    @JsonGetter("expires")
    public Period getExpires() {
        return this.expires;
    }
    @JsonSetter("range")
    public void setRange(Duration range) {
        this.range = range;
    }
    @JsonGetter("range")
    public Duration getRange() {
        return this.range;
    }
    @JsonSetter("price")
    public void setPrice(double price) {
        this.price = price;
    }
    @JsonGetter("price")
    public double getPrice() {
        return this.price;
    }
    @JsonSetter("rating")
    public void setRating(int rating) {
        this.rating = rating;
    }
    @JsonGetter("rating")
    public int getRating() {
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
    public void setCoffeeTime(LocalTime coffeeTime) {
        this.coffeeTime = coffeeTime;
    }
    @JsonGetter("coffeeTime")
    public LocalTime getCoffeeTime() {
        return this.coffeeTime;
    }
    @JsonSetter("profileUri")
    public void setProfileUri(URI profileUri) {
        this.profileUri = profileUri;
    }
    @JsonGetter("profileUri")
    public URI getProfileUri() {
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
    @JsonSetter("payload")
    public void setPayload(Object payload) {
        this.payload = payload;
    }
    @JsonGetter("payload")
    public Object getPayload() {
        return this.payload;
    }
}
