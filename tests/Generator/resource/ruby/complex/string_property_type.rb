
# Represents a string value
class StringPropertyType
  extend ScalarPropertyType
  attr_accessor :type, :format

  def initialize(type, format)
    @type = type
    @format = format
  end
end

