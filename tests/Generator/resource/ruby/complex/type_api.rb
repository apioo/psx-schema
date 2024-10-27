
# The TypeAPI Root
class TypeAPI
  extend TypeSchema
  attr_accessor :base_url, :security, :operations

  def initialize(base_url, security, operations)
    @base_url = base_url
    @security = security
    @operations = operations
  end
end

