module FooBar
class Import
    attr_accessor :students, :student

    def initialize(students, student)
        @students = students
        @student = student
    end
end
end

module FooBar
class MyMap
    extend My::Import::Student

    def initialize()
    end
end
end
