
# The TypeAPI Root
class TypeAPI
  extend TypeSchema
  attr_accessor :base_url, :operations, :security

  def initialize(base_url, operations, security)
    @base_url = base_url
    @operations = operations
    @security = security
  end
end

