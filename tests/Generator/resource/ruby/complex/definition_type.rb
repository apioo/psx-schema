
# Base definition type
class DefinitionType
  attr_accessor :deprecated, :description, :type

  def initialize(deprecated, description, type)
    @deprecated = deprecated
    @description = description
    @type = type
  end
end

