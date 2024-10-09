// Location of the person
class Location: Codable {
    var lat: Float
    var long: Float

    enum CodingKeys: String, CodingKey {
        case lat = "lat"
        case long = "long"
    }
}

// An application
class Web: Codable {
    var name: String
    var url: String

    enum CodingKeys: String, CodingKey {
        case name = "name"
        case url = "url"
    }
}

// An simple author element with some description
class Author: Codable {
    var title: String
    var email: String
    var categories: Array<String>
    var locations: Array<Location>
    var origin: Location

    enum CodingKeys: String, CodingKey {
        case title = "title"
        case email = "email"
        case categories = "categories"
        case locations = "locations"
        case origin = "origin"
    }
}

typealias Meta = Dictionary<String, String>;

// An general news entry
class News: Codable {
    var config: Meta
    var inlineConfig: Dictionary<String, String>
    var mapTags: Dictionary<String, String>
    var mapReceiver: Dictionary<String, Author>
    var mapResources: Dictionary<String, Location | Web>
    var tags: Array<String>
    var receiver: Array<Author>
    var resources: Array<Location | Web>
    var profileImage: String
    var read: Bool
    var source: Author | Web
    var author: Author
    var meta: Meta
    var sendDate: Date
    var readDate: Date
    var expires: String
    var range: String
    var price: Float
    var rating: Int
    var content: String
    var question: String
    var version: String
    var coffeeTime: String
    var profileUri: String
    var captcha: String
    var mediaFields: String
    var payload: Any

    enum CodingKeys: String, CodingKey {
        case config = "config"
        case inlineConfig = "inlineConfig"
        case mapTags = "mapTags"
        case mapReceiver = "mapReceiver"
        case mapResources = "mapResources"
        case tags = "tags"
        case receiver = "receiver"
        case resources = "resources"
        case profileImage = "profileImage"
        case read = "read"
        case source = "source"
        case author = "author"
        case meta = "meta"
        case sendDate = "sendDate"
        case readDate = "readDate"
        case expires = "expires"
        case range = "range"
        case price = "price"
        case rating = "rating"
        case content = "content"
        case question = "question"
        case version = "version"
        case coffeeTime = "coffeeTime"
        case profileUri = "profileUri"
        case captcha = "g-recaptcha-response"
        case mediaFields = "media.fields"
        case payload = "payload"
    }
}
