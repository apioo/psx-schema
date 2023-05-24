open class Creature {
    var kind: String? = null
}

open class Human : Creature {
    var firstName: String? = null
}

open class Animal : Creature {
    var nickname: String? = null
}

open class Union {
    var union: Any? = null
    var intersection: Any? = null
    var discriminator: Any? = null
}
