
# Represents a string value
class StringPropertyType
  extend ScalarPropertyType
  attr_accessor :default, :format, :type

  def initialize(default, format, type)
    @default = default
    @format = format
    @type = type
  end
end

