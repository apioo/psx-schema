open class Human {
    var firstName: String? = null
    var parent: Human? = null
}

open class Student : Human {
    var matricleNumber: String? = null
}

typealias StudentMap = Map<Student>

open class Map<T> {
    var totalResults: Int? = null
    var entries: Array<T>? = null
}

open class RootSchema {
    var students: StudentMap? = null
}
