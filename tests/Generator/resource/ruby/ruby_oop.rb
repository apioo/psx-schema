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

class Map
  attr_accessor :total_results, :parent, :entries

  def initialize(total_results, parent, entries)
    @total_results = total_results
    @parent = parent
    @entries = entries
  end
end

class StudentMap
  extend Map

  def initialize()
  end
end

class HumanMap
  extend Map

  def initialize()
  end
end

class RootSchema
  attr_accessor :students

  def initialize(students)
    @students = students
  end
end
