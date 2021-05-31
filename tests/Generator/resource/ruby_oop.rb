class Human
    attr_accessor :firstName

    def initialize(firstName)
        @firstName = firstName
    end
end

class Student
    extend Human
    attr_accessor :matricleNumber

    def initialize(matricleNumber)
        @matricleNumber = matricleNumber
    end
end

class StudentMap
    extend Map
end

class Map
    attr_accessor :totalResults, :entries

    def initialize(totalResults, entries)
        @totalResults = totalResults
        @entries = entries
    end
end

class RootSchema
    attr_accessor :students

    def initialize(students)
        @students = students
    end
end
