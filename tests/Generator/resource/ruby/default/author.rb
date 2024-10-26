
# An simple author element with some description
class Author
  attr_accessor :title, :email, :categories, :locations, :origin

  def initialize(title, email, categories, locations, origin)
    @title = title
    @email = email
    @categories = categories
    @locations = locations
    @origin = origin
  end
end

