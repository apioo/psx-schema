// Location of the person
class Location: Codable {
    var lat: Float?
    var long: Float?

    enum CodingKeys: String, CodingKey {
        case lat = "lat"
        case long = "long"
    }
}

