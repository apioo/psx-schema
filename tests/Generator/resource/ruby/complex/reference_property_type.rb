
# Represents a reference to a definition type
class ReferencePropertyType
  extend PropertyType
  attr_accessor :target, :template, :type

  def initialize(target, template, type)
    @target = target
    @template = template
    @type = type
  end
end

