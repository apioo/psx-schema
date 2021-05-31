package FooBar
struct Import {
    students: My::Import.StudentMap,
    student: My::Import.Student,
}

package FooBar
struct MyMap {
    *My::Import.Student
}
