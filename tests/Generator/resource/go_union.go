type Creature struct {
    Kind string `json:"kind"`
}

type Human struct {
    *Creature
    FirstName string `json:"firstName"`
}

type Animal struct {
    *Creature
    Nickname string `json:"nickname"`
}

type Union struct {
    Union interface{} `json:"union"`
    Intersection interface{} `json:"intersection"`
    Discriminator interface{} `json:"discriminator"`
}
