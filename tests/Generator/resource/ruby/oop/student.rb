class Student
  extend Human
  attr_accessor :matricle_number

  def initialize(matricle_number)
    @matricle_number = matricle_number
  end
end

