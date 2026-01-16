
# Represents an array which contains a dynamic list of values of the same type
class ArrayPropertyType
  extend CollectionPropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

