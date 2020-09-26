class Creature:
    def __init__(self, kind: str):
        self.kind = kind

class Human(Creature):
    def __init__(self, firstName: str):
        self.firstName = firstName

class Animal(Creature):
    def __init__(self, nickname: str):
        self.nickname = nickname

class Union:
    def __init__(self, union: , intersection: , discriminator: ):
        self.union = union
        self.intersection = intersection
        self.discriminator = discriminator
