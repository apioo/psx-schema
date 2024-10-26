class Student: Human {
    var matricleNumber: String

    enum CodingKeys: String, CodingKey {
        case matricleNumber = "matricleNumber"
    }
}

