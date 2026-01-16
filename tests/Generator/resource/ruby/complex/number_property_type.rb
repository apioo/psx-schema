
# Represents a float value
class NumberPropertyType
  extend ScalarPropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

