class Human
  attr_accessor :first_name, :parent

  def initialize(first_name, parent)
    @first_name = first_name
    @parent = parent
  end
end

class Student
  extend Human
  attr_accessor :matricle_number

  def initialize(matricle_number)
    @matricle_number = matricle_number
  end
end

class StudentMap
  extend Map
end

class Map
  attr_accessor :total_results, :entries

  def initialize(total_results, entries)
    @total_results = total_results
    @entries = entries
  end
end

class RootSchema
  attr_accessor :students

  def initialize(students)
    @students = students
  end
end
