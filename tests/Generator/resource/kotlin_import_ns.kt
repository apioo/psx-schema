package Foo.Bar;
open class Import {
    var students: My.Import.StudentMap? = null
    var student: My.Import.Student? = null
    open fun setStudents(students: My.Import.StudentMap?) {
        this.students = students;
    }
    open fun getStudents(): My.Import.StudentMap? {
        return this.students;
    }
    open fun setStudent(student: My.Import.Student?) {
        this.student = student;
    }
    open fun getStudent(): My.Import.Student? {
        return this.student;
    }
}

package Foo.Bar;
open class MyMap : My.Import.Student {
}
