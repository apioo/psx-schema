class Import
  attr_accessor :students, :student

  def initialize(students, student)
    @students = students
    @student = student
  end
end

class MyMap
  extend Student

  def initialize()
  end
end
