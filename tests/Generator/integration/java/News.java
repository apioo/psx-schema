package org.phpsx.test;

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
import java.net.URI;
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
    private Period expires;
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
