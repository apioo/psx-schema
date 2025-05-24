// An general news entry
class News: Codable {
    var config: Meta?
    var inlineConfig: Dictionary<String, String>?
    var mapTags: Dictionary<String, String>?
    var mapReceiver: Dictionary<String, Author>?
    var tags: Array<String>?
    var receiver: Array<Author>?
    var data: Array<Array<Float>>?
    var read: Bool?
    var author: Author
    var meta: Meta?
    var sendDate: Date?
    var readDate: Date?
    var price: Float?
    var rating: Int?
    var content: String
    var question: String?
    var version: String?
    var coffeeTime: String?
    var captcha: String?
    var mediaFields: String?
    var payload: Any?

    enum CodingKeys: String, CodingKey {
        case config = "config"
        case inlineConfig = "inlineConfig"
        case mapTags = "mapTags"
        case mapReceiver = "mapReceiver"
        case tags = "tags"
        case receiver = "receiver"
        case data = "data"
        case read = "read"
        case author = "author"
        case meta = "meta"
        case sendDate = "sendDate"
        case readDate = "readDate"
        case price = "price"
        case rating = "rating"
        case content = "content"
        case question = "question"
        case version = "version"
        case coffeeTime = "coffeeTime"
        case captcha = "g-recaptcha-response"
        case mediaFields = "media.fields"
        case payload = "payload"
    }
}

