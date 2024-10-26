class Map<P, T>: Codable {
    var totalResults: Int
    var parent: P
    var entries: Array<T>

    enum CodingKeys: String, CodingKey {
        case totalResults = "totalResults"
        case parent = "parent"
        case entries = "entries"
    }
}

