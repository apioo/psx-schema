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
    attr_accessor :config, :inlineConfig, :tags, :receiver, :resources, :profileImage, :read, :source, :author, :meta, :sendDate, :readDate, :expires, :price, :rating, :content, :question, :version, :coffeeTime, :profileUri, :captcha, :payload

    def initialize(config, inlineConfig, tags, receiver, resources, profileImage, read, source, author, meta, sendDate, readDate, expires, price, rating, content, question, version, coffeeTime, profileUri, captcha, payload)
        @config = config
        @inlineConfig = inlineConfig
        @tags = tags
        @receiver = receiver
        @resources = resources
        @profileImage = profileImage
        @read = read
        @source = source
        @author = author
        @meta = meta
        @sendDate = sendDate
        @readDate = readDate
        @expires = expires
        @price = price
        @rating = rating
        @content = content
        @question = question
        @version = version
        @coffeeTime = coffeeTime
        @profileUri = profileUri
        @captcha = captcha
        @payload = payload
    end
end
