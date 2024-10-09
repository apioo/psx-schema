open class Human {
    var firstName: String? = null
    var parent: Human? = null
}

open class Student : Human {
    var matricleNumber: String? = null
}

open class Map<P, T> {
    var totalResults: Int? = null
    var parent: P? = null
    var entries: Array<T>? = null
}

open class StudentMap : Map<Human, Student> {
}

open class HumanMap : Map<Human, Human> {
}

open class RootSchema {
    var students: StudentMap? = null
}
