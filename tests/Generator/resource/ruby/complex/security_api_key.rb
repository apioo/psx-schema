class SecurityApiKey
  extend Security
  attr_accessor :in, :name

  def initialize(in, name)
    @in = in
    @name = name
  end
end

