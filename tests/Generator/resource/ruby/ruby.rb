# Location of the person
class Location
    attr_accessor :lat, :long

    def initialize(lat, long)
        @lat = lat
        @long = long
    end
end

# An application
class Web
    attr_accessor :name, :url

    def initialize(name, url)
        @name = name
        @url = url
    end
end

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

# An general news entry
class News
    attr_accessor :config, :inline_config, :map_tags, :map_receiver, :map_resources, :tags, :receiver, :resources, :profile_image, :read, :source, :author, :meta, :send_date, :read_date, :expires, :range, :price, :rating, :content, :question, :version, :coffee_time, :profile_uri, :captcha, :payload

    def initialize(config, inline_config, map_tags, map_receiver, map_resources, tags, receiver, resources, profile_image, read, source, author, meta, send_date, read_date, expires, range, price, rating, content, question, version, coffee_time, profile_uri, captcha, payload)
        @config = config
        @inline_config = inline_config
        @map_tags = map_tags
        @map_receiver = map_receiver
        @map_resources = map_resources
        @tags = tags
        @receiver = receiver
        @resources = resources
        @profile_image = profile_image
        @read = read
        @source = source
        @author = author
        @meta = meta
        @send_date = send_date
        @read_date = read_date
        @expires = expires
        @range = range
        @price = price
        @rating = rating
        @content = content
        @question = question
        @version = version
        @coffee_time = coffee_time
        @profile_uri = profile_uri
        @captcha = captcha
        @payload = payload
    end
end
