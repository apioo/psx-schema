
# Base scalar property type
class ScalarPropertyType
  extend PropertyType
  attr_accessor :type

  def initialize(type)
    @type = type
  end
end

