
# Base definition type
class DefinitionType
  attr_accessor :description, :type, :deprecated

  def initialize(description, type, deprecated)
    @description = description
    @type = type
    @deprecated = deprecated
  end
end

