
# Represents a reference to a definition type
class ReferencePropertyType
  extend PropertyType
  attr_accessor :target, :template

  def initialize(target, template)
    @target = target
    @template = template
  end
end

