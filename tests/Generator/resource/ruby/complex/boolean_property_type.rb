
# Represents a boolean value
class BooleanPropertyType
  extend ScalarPropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

