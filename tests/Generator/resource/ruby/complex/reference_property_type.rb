
# Represents a reference to a definition type
class ReferencePropertyType
  extend PropertyType
  attr_accessor :type, :target

  def initialize(type, target)
    @type = type
    @target = target
  end
end

