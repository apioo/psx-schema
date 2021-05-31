/**
 * Location of the person
 */
open class Location {
    var lat: Float? = null
    var long: Float? = null
    open fun setLat(lat: Float?) {
        this.lat = lat;
    }
    open fun getLat(): Float? {
        return this.lat;
    }
    open fun setLong(long: Float?) {
        this.long = long;
    }
    open fun getLong(): Float? {
        return this.long;
    }
}

/**
 * An application
 */
open class Web {
    var name: String? = null
    var url: String? = null
    open fun setName(name: String?) {
        this.name = name;
    }
    open fun getName(): String? {
        return this.name;
    }
    open fun setUrl(url: String?) {
        this.url = url;
    }
    open fun getUrl(): String? {
        return this.url;
    }
}

/**
 * An simple author element with some description
 */
open class Author {
    var title: String? = null
    var email: String? = null
    var categories: Array<String>? = null
    var locations: Array<Location>? = null
    var origin: Location? = null
    open fun setTitle(title: String?) {
        this.title = title;
    }
    open fun getTitle(): String? {
        return this.title;
    }
    open fun setEmail(email: String?) {
        this.email = email;
    }
    open fun getEmail(): String? {
        return this.email;
    }
    open fun setCategories(categories: Array<String>?) {
        this.categories = categories;
    }
    open fun getCategories(): Array<String>? {
        return this.categories;
    }
    open fun setLocations(locations: Array<Location>?) {
        this.locations = locations;
    }
    open fun getLocations(): Array<Location>? {
        return this.locations;
    }
    open fun setOrigin(origin: Location?) {
        this.origin = origin;
    }
    open fun getOrigin(): Location? {
        return this.origin;
    }
}

open class Meta : HashMap<String, String>() {
}

/**
 * An general news entry
 */
open class News {
    var config: Meta? = null
    var tags: Array<String>? = null
    var receiver: Array<Author>? = null
    var resources: Array<Object>? = null
    var profileImage: String? = null
    var read: Boolean? = null
    var source: Object? = null
    var author: Author? = null
    var meta: Meta? = null
    var sendDate: String? = null
    var readDate: String? = null
    var expires: String? = null
    var price: Float? = null
    var rating: Int? = null
    var content: String? = null
    var question: String? = null
    var version: String? = null
    var coffeeTime: String? = null
    var profileUri: String? = null
    var captcha: String? = null
    open fun setConfig(config: Meta?) {
        this.config = config;
    }
    open fun getConfig(): Meta? {
        return this.config;
    }
    open fun setTags(tags: Array<String>?) {
        this.tags = tags;
    }
    open fun getTags(): Array<String>? {
        return this.tags;
    }
    open fun setReceiver(receiver: Array<Author>?) {
        this.receiver = receiver;
    }
    open fun getReceiver(): Array<Author>? {
        return this.receiver;
    }
    open fun setResources(resources: Array<Object>?) {
        this.resources = resources;
    }
    open fun getResources(): Array<Object>? {
        return this.resources;
    }
    open fun setProfileImage(profileImage: String?) {
        this.profileImage = profileImage;
    }
    open fun getProfileImage(): String? {
        return this.profileImage;
    }
    open fun setRead(read: Boolean?) {
        this.read = read;
    }
    open fun getRead(): Boolean? {
        return this.read;
    }
    open fun setSource(source: Object?) {
        this.source = source;
    }
    open fun getSource(): Object? {
        return this.source;
    }
    open fun setAuthor(author: Author?) {
        this.author = author;
    }
    open fun getAuthor(): Author? {
        return this.author;
    }
    open fun setMeta(meta: Meta?) {
        this.meta = meta;
    }
    open fun getMeta(): Meta? {
        return this.meta;
    }
    open fun setSendDate(sendDate: String?) {
        this.sendDate = sendDate;
    }
    open fun getSendDate(): String? {
        return this.sendDate;
    }
    open fun setReadDate(readDate: String?) {
        this.readDate = readDate;
    }
    open fun getReadDate(): String? {
        return this.readDate;
    }
    open fun setExpires(expires: String?) {
        this.expires = expires;
    }
    open fun getExpires(): String? {
        return this.expires;
    }
    open fun setPrice(price: Float?) {
        this.price = price;
    }
    open fun getPrice(): Float? {
        return this.price;
    }
    open fun setRating(rating: Int?) {
        this.rating = rating;
    }
    open fun getRating(): Int? {
        return this.rating;
    }
    open fun setContent(content: String?) {
        this.content = content;
    }
    open fun getContent(): String? {
        return this.content;
    }
    open fun setQuestion(question: String?) {
        this.question = question;
    }
    open fun getQuestion(): String? {
        return this.question;
    }
    open fun setVersion(version: String?) {
        this.version = version;
    }
    open fun getVersion(): String? {
        return this.version;
    }
    open fun setCoffeeTime(coffeeTime: String?) {
        this.coffeeTime = coffeeTime;
    }
    open fun getCoffeeTime(): String? {
        return this.coffeeTime;
    }
    open fun setProfileUri(profileUri: String?) {
        this.profileUri = profileUri;
    }
    open fun getProfileUri(): String? {
        return this.profileUri;
    }
    open fun setCaptcha(captcha: String?) {
        this.captcha = captcha;
    }
    open fun getCaptcha(): String? {
        return this.captcha;
    }
}
