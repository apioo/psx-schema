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
    var union: Any? = null
    var intersection: Any? = null
    var discriminator: Any? = null
    open fun setUnion(union: Any?) {
        this.union = union;
    }
    open fun getUnion(): Any? {
        return this.union;
    }
    open fun setIntersection(intersection: Any?) {
        this.intersection = intersection;
    }
    open fun getIntersection(): Any? {
        return this.intersection;
    }
    open fun setDiscriminator(discriminator: Any?) {
        this.discriminator = discriminator;
    }
    open fun getDiscriminator(): Any? {
        return this.discriminator;
    }
}
