
# Base definition type
class DefinitionType
  attr_accessor :description, :deprecated, :type

  def initialize(description, deprecated, type)
    @description = description
    @deprecated = deprecated
    @type = type
  end
end

