
# Represents a string value
class StringPropertyType
  extend ScalarPropertyType
  attr_accessor :format

  def initialize(format)
    @format = format
  end
end

