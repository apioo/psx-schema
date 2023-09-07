/**
 * Location of the person
 */
open class Location {
    var lat: Float? = null
    var long: Float? = null
}

/**
 * An application
 */
open class Web {
    var name: String? = null
    var url: String? = null
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
}

import java.util.HashMap;
open class Meta : HashMap<String, String>() {
}

import java.net.URI;
import java.time.Duration;
import java.time.LocalDate;
import java.time.LocalTime;
import java.time.LocalDateTime;
import java.util.HashMap;

/**
 * An general news entry
 */
open class News {
    var config: Meta? = null
    var inlineConfig: HashMap<String, String>? = null
    var mapTags: HashMap<String, String>? = null
    var mapReceiver: HashMap<String, Author>? = null
    var mapResources: HashMap<String, Any>? = null
    var tags: Array<String>? = null
    var receiver: Array<Author>? = null
    var resources: Array<Any>? = null
    var profileImage: ByteArray? = null
    var read: Boolean? = null
    var source: Any? = null
    var author: Author? = null
    var meta: Meta? = null
    var sendDate: LocalDate? = null
    var readDate: LocalDateTime? = null
    var expires: Period? = null
    var range: Duration? = null
    var price: Float? = null
    var rating: Int? = null
    var content: String? = null
    var question: String? = null
    var version: String? = null
    var coffeeTime: LocalTime? = null
    var profileUri: URI? = null
    var captcha: String? = null
    var payload: Any? = null
}
