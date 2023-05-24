package Foo.Bar;
open class Import {
    var students: My.Import.StudentMap? = null
    var student: My.Import.Student? = null
}

package Foo.Bar;
open class MyMap : My.Import.Student {
}
