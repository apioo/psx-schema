
# Represents an integer value
class IntegerPropertyType
  extend ScalarPropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

