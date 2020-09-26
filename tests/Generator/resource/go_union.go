// Creature
type Creature struct {
    Kind string `json:"kind"`
}

// Human
type Human struct {
    *Creature
    FirstName string `json:"firstName"`
}

// Animal
type Animal struct {
    *Creature
    Nickname string `json:"nickname"`
}

// Union
type Union struct {
    Union interface{} `json:"union"`
    Intersection interface{} `json:"intersection"`
    Discriminator interface{} `json:"discriminator"`
}
