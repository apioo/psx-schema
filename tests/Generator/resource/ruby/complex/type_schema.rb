
# TypeSchema specification
class TypeSchema
  attr_accessor :definitions, :import, :root

  def initialize(definitions, import, root)
    @definitions = definitions
    @import = import
    @root = root
  end
end

