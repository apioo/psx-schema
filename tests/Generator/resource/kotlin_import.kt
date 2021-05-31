open class Import {
    var students: StudentMap? = null
    var student: Student? = null
    open fun setStudents(students: StudentMap?) {
        this.students = students;
    }
    open fun getStudents(): StudentMap? {
        return this.students;
    }
    open fun setStudent(student: Student?) {
        this.student = student;
    }
    open fun getStudent(): Student? {
        return this.student;
    }
}

open class MyMap : Student {
}
