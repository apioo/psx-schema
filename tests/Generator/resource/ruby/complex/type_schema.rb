
# TypeSchema specification
class TypeSchema
  attr_accessor :import, :definitions, :root

  def initialize(import, definitions, root)
    @import = import
    @definitions = definitions
    @root = root
  end
end

