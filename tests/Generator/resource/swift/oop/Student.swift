class Student: HumanType {
    var matricleNumber: String?

    enum CodingKeys: String, CodingKey {
        case matricleNumber = "matricleNumber"
    }
}

