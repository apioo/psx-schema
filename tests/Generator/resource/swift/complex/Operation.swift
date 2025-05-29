class Operation: Codable {
    var arguments: Dictionary<String, Argument>?
    var authorization: Bool?
    var description: String?
    var method: String?
    var path: String?
    var _return: Response?
    var security: Array<String>?
    var stability: Int?
    var _throws: Array<Response>?

    enum CodingKeys: String, CodingKey {
        case arguments = "arguments"
        case authorization = "authorization"
        case description = "description"
        case method = "method"
        case path = "path"
        case _return = "return"
        case security = "security"
        case stability = "stability"
        case _throws = "throws"
    }
}

