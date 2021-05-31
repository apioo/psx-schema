open class Human {
    var firstName: String? = null
    open fun setFirstName(firstName: String?) {
        this.firstName = firstName;
    }
    open fun getFirstName(): String? {
        return this.firstName;
    }
}

open class Student : Human {
    var matricleNumber: String? = null
    open fun setMatricleNumber(matricleNumber: String?) {
        this.matricleNumber = matricleNumber;
    }
    open fun getMatricleNumber(): String? {
        return this.matricleNumber;
    }
}

typealias StudentMap = Map<Student>

open class Map<T> {
    var totalResults: Int? = null
    var entries: Array<T>? = null
    open fun setTotalResults(totalResults: Int?) {
        this.totalResults = totalResults;
    }
    open fun getTotalResults(): Int? {
        return this.totalResults;
    }
    open fun setEntries(entries: Array<T>?) {
        this.entries = entries;
    }
    open fun getEntries(): Array<T>? {
        return this.entries;
    }
}

open class RootSchema {
    var students: StudentMap? = null
    open fun setStudents(students: StudentMap?) {
        this.students = students;
    }
    open fun getStudents(): StudentMap? {
        return this.students;
    }
}
