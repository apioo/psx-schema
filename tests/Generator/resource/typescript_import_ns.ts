namespace Foo.Bar {
export interface Import {
    students?: My.Import.StudentMap
    student?: My.Import.Student
}
}

namespace Foo.Bar {
export interface MyMap extends My.Import.Student {
}
}
