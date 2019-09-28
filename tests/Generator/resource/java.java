public static class News {
    private Config config;
    private String[] tags;
    private Author[] receiver;
    private Object[] resources;
    private String profileImage;
    private boolean read;
    private Object source;
    private Author author;
    private Meta meta;
    private String sendDate;
    private String readDate;
    private String expires;
    private float price;
    private int rating;
    private String content;
    private String question;
    private String version;
    private String coffeeTime;
    private String profileUri;
    private String gRecaptchaResponse;
    public void setConfig(Config config) {
        this.config = config;
    }
    public Config getConfig() {
        return this.config;
    }
    public void setTags(String[] tags) {
        this.tags = tags;
    }
    public String[] getTags() {
        return this.tags;
    }
    public void setReceiver(Author[] receiver) {
        this.receiver = receiver;
    }
    public Author[] getReceiver() {
        return this.receiver;
    }
    public void setResources(Object[] resources) {
        this.resources = resources;
    }
    public Object[] getResources() {
        return this.resources;
    }
    public void setProfileImage(String profileImage) {
        this.profileImage = profileImage;
    }
    public String getProfileImage() {
        return this.profileImage;
    }
    public void setRead(boolean read) {
        this.read = read;
    }
    public boolean getRead() {
        return this.read;
    }
    public void setSource(Object source) {
        this.source = source;
    }
    public Object getSource() {
        return this.source;
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
    public void setSendDate(String sendDate) {
        this.sendDate = sendDate;
    }
    public String getSendDate() {
        return this.sendDate;
    }
    public void setReadDate(String readDate) {
        this.readDate = readDate;
    }
    public String getReadDate() {
        return this.readDate;
    }
    public void setExpires(String expires) {
        this.expires = expires;
    }
    public String getExpires() {
        return this.expires;
    }
    public void setPrice(float price) {
        this.price = price;
    }
    public float getPrice() {
        return this.price;
    }
    public void setRating(int rating) {
        this.rating = rating;
    }
    public int getRating() {
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
    public void setCoffeeTime(String coffeeTime) {
        this.coffeeTime = coffeeTime;
    }
    public String getCoffeeTime() {
        return this.coffeeTime;
    }
    public void setProfileUri(String profileUri) {
        this.profileUri = profileUri;
    }
    public String getProfileUri() {
        return this.profileUri;
    }
    public void setGRecaptchaResponse(String gRecaptchaResponse) {
        this.gRecaptchaResponse = gRecaptchaResponse;
    }
    public String getGRecaptchaResponse() {
        return this.gRecaptchaResponse;
    }
}
public static class Config extends HashMap<String, String> {
}
public static class Author {
    private String title;
    private Object email;
    private String[] categories;
    private Location[] locations;
    private Location origin;
    public void setTitle(String title) {
        this.title = title;
    }
    public String getTitle() {
        return this.title;
    }
    public void setEmail(Object email) {
        this.email = email;
    }
    public Object getEmail() {
        return this.email;
    }
    public void setCategories(String[] categories) {
        this.categories = categories;
    }
    public String[] getCategories() {
        return this.categories;
    }
    public void setLocations(Location[] locations) {
        this.locations = locations;
    }
    public Location[] getLocations() {
        return this.locations;
    }
    public void setOrigin(Location origin) {
        this.origin = origin;
    }
    public Location getOrigin() {
        return this.origin;
    }
}
public static class Web extends HashMap<String, String> {
    private String name;
    private String url;
    public void setName(String name) {
        this.name = name;
    }
    public String getName() {
        return this.name;
    }
    public void setUrl(String url) {
        this.url = url;
    }
    public String getUrl() {
        return this.url;
    }
}
public static class Meta {
    private String createDate;
    public void setCreateDate(String createDate) {
        this.createDate = createDate;
    }
    public String getCreateDate() {
        return this.createDate;
    }
}
public static class Location extends HashMap<String, Object> {
    private float lat;
    private float long;
    public void setLat(float lat) {
        this.lat = lat;
    }
    public float getLat() {
        return this.lat;
    }
    public void setLong(float long) {
        this.long = long;
    }
    public float getLong() {
        return this.long;
    }
}
