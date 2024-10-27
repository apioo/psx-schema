class Operation: Codable {
    var method: String
    var path: String
    var _return: Response
    var arguments: Dictionary<String, Argument>
    var _throws: Array<Response>
    var description: String
    var stability: Int
    var security: Array<String>
    var authorization: Bool
    var tags: Array<String>

    enum CodingKeys: String, CodingKey {
        case method = "method"
        case path = "path"
        case _return = "return"
        case arguments = "arguments"
        case _throws = "throws"
        case description = "description"
        case stability = "stability"
        case security = "security"
        case authorization = "authorization"
        case tags = "tags"
    }
}

