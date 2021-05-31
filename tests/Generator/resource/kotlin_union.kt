open class Creature {
    var kind: String? = null
    open fun setKind(kind: String?) {
        this.kind = kind;
    }
    open fun getKind(): String? {
        return this.kind;
    }
}

open class Human : Creature {
    var firstName: String? = null
    open fun setFirstName(firstName: String?) {
        this.firstName = firstName;
    }
    open fun getFirstName(): String? {
        return this.firstName;
    }
}

open class Animal : Creature {
    var nickname: String? = null
    open fun setNickname(nickname: String?) {
        this.nickname = nickname;
    }
    open fun getNickname(): String? {
        return this.nickname;
    }
}

open class Union {
    var union: Object? = null
    var intersection: Object? = null
    var discriminator: Object? = null
    open fun setUnion(union: Object?) {
        this.union = union;
    }
    open fun getUnion(): Object? {
        return this.union;
    }
    open fun setIntersection(intersection: Object?) {
        this.intersection = intersection;
    }
    open fun getIntersection(): Object? {
        return this.intersection;
    }
    open fun setDiscriminator(discriminator: Object?) {
        this.discriminator = discriminator;
    }
    open fun getDiscriminator(): Object? {
        return this.discriminator;
    }
}
