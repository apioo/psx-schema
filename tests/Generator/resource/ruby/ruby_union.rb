class Creature
  attr_accessor :kind

  def initialize(kind)
    @kind = kind
  end
end

class Human
  extend Creature
  attr_accessor :first_name

  def initialize(first_name)
    @first_name = first_name
  end
end

class Animal
  extend Creature
  attr_accessor :nickname

  def initialize(nickname)
    @nickname = nickname
  end
end

class Union
  attr_accessor :union, :intersection, :discriminator

  def initialize(union, intersection, discriminator)
    @union = union
    @intersection = intersection
    @discriminator = discriminator
  end
end
