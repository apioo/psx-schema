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

