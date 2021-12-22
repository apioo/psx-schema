// Location of the person
class Location: Codable {
    var lat: Float
    var long: Float
}

// An application
class Web: Codable {
    var name: String
    var url: String
}

// An simple author element with some description
class Author: Codable {
    var title: String
    var email: String
    var categories: Array<String>
    var locations: Array<Location>
    var origin: Location
}

typealias Meta = Dictionary<String, String>;

// An general news entry
class News: Codable {
    var config: Meta
    var tags: Array<String>
    var receiver: Array<Author>
    var resources: Array<Location | Web>
    var profileImage: String
    var read: Bool
    var source: Author | Web
    var author: Author
    var meta: Meta
    var sendDate: String
    var readDate: String
    var expires: String
    var price: Float
    var rating: Int
    var content: String
    var question: String
    var version: String
    var coffeeTime: String
    var profileUri: String
    var captcha: String
    var payload: Any
}
