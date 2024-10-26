
# Represents an array which contains a dynamic list of values
class ArrayDefinitionType
  extend CollectionDefinitionType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

